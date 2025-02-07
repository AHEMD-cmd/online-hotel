<?php

namespace App\Http\Controllers\Front;

use DB;
use Stripe;
use App\Models\Cart;
use App\Models\Room;
use App\Models\Order;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use App\Mail\Websitemail;
use App\Models\BookedRoom;
use App\Models\OrderDetail;
use PayPal\Api\Transaction;
use Illuminate\Http\Request;
use App\Services\CartService;
use PayPal\Api\PaymentExecution;
use App\Events\CartUpdated;
use App\Http\Requests\CartRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PaymentRequest;


class BookingController extends Controller
{
    protected $cart;

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    public function store(CartRequest $request, CartService $cart)
    {
        // Add item to cart
        Cart::create(array_merge($request->validated(), [
            'uuid' => $cart->getCartId(),
        ]));

        $cartCount = Cart::where('user_id', auth()->id())
            ->orWhere('uuid', $cart->getCartId())
            ->count();

        broadcast(new CartUpdated($cartCount));

        return response()->json([
            'success' => true,
            'message' => 'Room is added to the cart successfully.',
        ]);
    }

    // $cartCount = Cart::where('user_id', auth()->id())->orWhere('uuid', $cart->getCartId())->count();
    // broadcast(new CartUpdated($cartCount, auth()->id()));


    public function index()
    {
        $rooms = Room::paginate(12);
        $cartItems = Cart::where('user_id', Auth::id())
            ->orWhere('uuid', $this->cart->getCartId())
            ->get();
        $cartTotal = $cartItems->sum('subtotal');
        return view('front.cart', compact('rooms', 'cartItems', 'cartTotal'));
    }

    public function delete($id)
    {
        Cart::find($id)->delete();
        return redirect()->back()->with('success', 'Cart item is deleted.');
    }


    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->orWhere('uuid', $this->cart->getCartId())
            ->get();
        $cartTotal = $cartItems->sum('subtotal');
        return view('front.checkout', compact('cartItems', 'cartTotal'));
    }

    public function payment(PaymentRequest $request)
    {

        session()->put('billing_name', $request->billing_name);
        session()->put('billing_email', $request->billing_email);
        session()->put('billing_phone', $request->billing_phone);
        session()->put('billing_country', $request->billing_country);
        session()->put('billing_address', $request->billing_address);
        session()->put('billing_state', $request->billing_state);
        session()->put('billing_city', $request->billing_city);
        session()->put('billing_zip', $request->billing_zip);

        $cartItems = Cart::where('user_id', Auth::id())
            ->orWhere('uuid', $this->cart->getCartId())
            ->get();
        $cartTotal = $cartItems->sum('subtotal');
        // dd($cartTotal, $cartItems);
        return view('front.payment', compact('cartItems', 'cartTotal'));
    }
}
