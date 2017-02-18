<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Payments\Robokassa\Payment;
use App\Services\Payments\Managers\CatalogManager;
use App\Services\Payments\Managers\CartManager;

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
        $this->app->bind('payment.manager.cart', function () {
            return new CartManager($this->app->make('qm'), $this->app->make('cart'));
        });

        $this->app->bind('payment.manager.catalog', function () {
            return new CatalogManager($this->app->make('qm'), $this->app->make('cart'));
        });

        $this->app->bind('payment.robokassa', function () {
            return new Payment(
                s_get('payment.method.robokassa.login'),
                s_get('payment.method.robokassa.password1'),
                s_get('payment.method.robokassa.password2'),
                s_get('payment.method.robokassa.hash'),
                (bool)s_get('payment.method.robokassa.test')
            );
        });
    }
}
