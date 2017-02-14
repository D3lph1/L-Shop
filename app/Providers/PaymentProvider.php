<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PaymentAssistant\Payments\Robokassa;

class PaymentProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('payment.robokassa', function () {
            return new Robokassa(
                s_get('payment.method.robokassa.login'),
                s_get('payment.method.robokassa.password'),
                s_get('payment.method.robokassa.hash'),
                (bool)s_get('payment.method.robokassa.test')
            );
        });
    }
}
