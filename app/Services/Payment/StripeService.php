<?php

namespace App\Services\Payment;

use Stripe\StripeClient;
use Illuminate\Support\Facades\Session;

class StripeService implements PaymentMethodInterface
{
    protected $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('stripe.stripe_sk'));
    }

    public function pay(array $data)
    {
        $response = $this->stripe->checkout->sessions->create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'room booking',
                        ],
                        'unit_amount' => $data['totalPrice'] * 100,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}&payment_method=Stripe',
            'cancel_url' => route('stripe.cancel'),
        ]);

        if (isset($response->id) && $response->id != '') {
            Session::put('payment_method', 'Stripe');
            return redirect($response->url);
        }

        return redirect()->route('stripe_cancel');
    }

    public function handleSuccess(array $data)
    {
        if (isset($data['session_id'])) {
            $response = $this->stripe->checkout->sessions->retrieve($data['session_id']);

            return [
                'status' => 'success',
            ];
        }

        return ['status' => 'error'];
    }

    public function handleCancel()
    {
        return ['status' => 'error', 'message' => 'Payment is cancelled!'];
    }
}