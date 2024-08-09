<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Braintree\Gateway;

class BraintreeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Gateway::class, function ($app) {
            return new Gateway([
                'environment' => env("BRAINTREE_ENV", "sandbox"),
                'merchantId' => env("MERCHANT_ID"),
                'publicKey' => env("PUBLIC_KEY"),
                'privateKey' => env("PRIVATE_KEY"),
            ]);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
