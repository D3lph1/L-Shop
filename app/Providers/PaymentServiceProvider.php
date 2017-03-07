<?php

namespace App\Providers;

use App\Services\PaymentManager;
use App\Services\Payments\Manager;
use Illuminate\Support\ServiceProvider;
use App\Services\Payments\Robokassa\Payment;

/**
 * Class PaymentServiceProvider
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Providers
 */
class PaymentServiceProvider extends ServiceProvider
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
        $this->app->bind('payment.manager', function () {
            return new Manager($this->app->make('qm'));
        });

        $this->app->bind('payment.robokassa', function () {
            return new Payment(
                s_get('payment.method.robokassa.login'),
                s_get('payment.method.robokassa.password1'),
                s_get('payment.method.robokassa.password2'),
                s_get('payment.method.robokassa.algo'),
                (bool)s_get('payment.method.robokassa.test')
            );
        });
    }
}
