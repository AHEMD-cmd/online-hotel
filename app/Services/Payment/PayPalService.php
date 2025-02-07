<?php

namespace App\Services\Payment;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;

class PayPalService implements PaymentMethodInterface
{
    protected $provider;

    public function __construct()
    {
        $this->provider = new PayPalClient;
        $this->provider->setApiCredentials(config('paypal'));
        $this->provider->getAccessToken();
    }

    public function pay(array $data)
    {
        $response = $this->provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.success') . "?payment_method=PayPal",
                "cancel_url" => route('paypal.cancel')
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $data['totalPrice']
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] == 'approve') {
                    Session::put('payment_method', 'PayPal');
                    return redirect()->away($link['href']);
                }
            }
        }

        return redirect()->route('paypal.cancel');
    }

    public function handleSuccess(array $data)
    {
        $response = $this->provider->capturePaymentOrder($data['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
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
