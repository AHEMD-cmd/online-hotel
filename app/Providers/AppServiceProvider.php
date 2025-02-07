<?php

namespace App\Providers;

use App\Models\Room;
use App\Models\Setting;
use App\Services\CartService;
use Filament\Facades\Filament;
use Illuminate\Pagination\Paginator;
use App\Services\Payment\CashService;
use App\Services\Payment\PayPalService;
use App\Services\Payment\StripeService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use App\Services\Payment\PaymentMethodInterface;
use App\Http\Controllers\Front\PaymentController;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentMethodInterface::class, PayPalService::class);

        // Contextual binding based on payment method
        $this->app->when(PaymentController::class)
            ->needs(PaymentMethodInterface::class)
            ->give(function ($app) {
                $request = $app->make('request');
                $paymentMethod = $request->input('payment_method') ?? session('payment_method');

                
                if (!$paymentMethod) {
                    throw new \InvalidArgumentException("Payment method not specified.");
                }
                
                switch ($paymentMethod) {
                    case 'PayPal':
                        // dd($paymentMethod);
                        return new PayPalService;
                    case 'Stripe':
                        return new StripeService;
                    default:
                        throw new \InvalidArgumentException("Invalid payment method: {$paymentMethod}");
                }
            });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


        Paginator::useBootstrap();

        Model::unguard();

        // Fetch the first record from the settings table
        $settings = Setting::first();
        $rooms = Room::all();
        $cartId = (new CartService)->getCartId();

        // Share the settings variable with all views
        view()->share('settings', $settings);
        view()->share('rooms', $rooms);
        view()->share('cartId', $cartId);

        Filament::registerRenderHook(
            'head.end',
            fn(): string => '
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
                <style>
                    .fa {
                        font-size: 1.5rem;
                        color: #3b82f6;
                    }
                </style>
            ',
        );
    }
}
