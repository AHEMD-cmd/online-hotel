<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\WhatsAppService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Services\Payment\PaymentMethodInterface;

class PaymentController extends Controller
{
    protected $paymentService;
    protected $orderService;
    protected $cartService;
    protected $whatsAppService;

    public function __construct(
        PaymentMethodInterface $paymentService,
        OrderService $orderService,
        CartService $cartService,
        WhatsAppService $whatsAppService
    ) {
        $this->paymentService = $paymentService;
        $this->orderService = $orderService;
        $this->cartService = $cartService;
        $this->whatsAppService = $whatsAppService;

    }

    public function payment(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:PayPal,Stripe',
        ]);
        // Store payment method in session
        Session::put('payment_method', $request->payment_method);

        // Prepare payment data
        $totalPrice = Cart::where('user_id', auth()->id())->sum('subtotal');

        $paymentData = [
            'user_id' => auth()->id(),
            'totalPrice' => $totalPrice,
        ];

        // Process payment using the resolved payment service
        return $this->paymentService->pay($paymentData);
    }

    public function paypalSuccess(Request $request)
    {
        $result = $this->paymentService->handleSuccess(['token' => $request->token]);

        if ($result['status'] === 'success') {

            $this->orderService->saveOrder([
                'user_id' => auth()->id(),
                'order_no' => Str::uuid(),
                'transaction_id' => '123456789',
                'payment_method' => 'PayPal',
                'paid_amount' => Cart::where('user_id', auth()->id())->sum('subtotal'),
                'booking_date' => date('Y-m-d'),
                'status' => 'Completed',
            ]);

            // clear cart data
            $this->cartService->deleteCart();

            //send whatsapp message
            $this->whatsAppService->send();

            Session::forget(['payment_method']);

            return redirect()->route('home')->with('success', 'Payment is successful!');
        }


        return redirect()->route('paypal.cancel');
    }

    public function stripeSuccess(Request $request)
    {
        $result = $this->paymentService->handleSuccess(['session_id' => $request->session_id]);

        if ($result['status'] === 'success') {
            $this->orderService->saveOrder([
                'user_id' => auth()->id(),
                'order_no' => Str::uuid(),
                'transaction_id' => '123456789',
                'payment_method' => 'Stripe',
                'paid_amount' => Cart::where('user_id', auth()->id())->sum('subtotal'),
                'booking_date' => date('Y-m-d'),
                'status' => 'Completed',
            ]);

            // Clear cart data
            $this->cartService->deleteCart();

            //send whatsapp message
            $this->whatsAppService->send();


            Session::forget(['payment_method']);


            return redirect()->route('home')->with('success', 'Payment is successful!');
        }

        return redirect()->route('stripe_cancel');
    }

    public function paypalCancel()
    {
        $result = $this->paymentService->handleCancel();
        return redirect()->back()->with('error', $result['message']);
    }

    public function stripeCancel()
    {
        $result = $this->paymentService->handleCancel();
        return redirect()->back()->with('error', $result['message']);
    }
}
