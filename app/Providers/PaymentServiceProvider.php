<?php
declare(strict_types = 1);

namespace App\Providers;

use App\Services\Payments\Interkassa\Checkout as InterkassaCheckout;
use App\Services\Payments\Manager;
use App\Services\Payments\Robokassa\Checkout as RobokassaCheckout;
use Illuminate\Support\ServiceProvider;

/**
 * Class PaymentServiceProvider
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Providers
 */
class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->app->alias(Manager::class, 'payment.manager');

        $this->app->singleton(RobokassaCheckout::class, function () {
            return new RobokassaCheckout(
                s_get('payment.method.robokassa.login'),
                s_get('payment.method.robokassa.password1'),
                s_get('payment.method.robokassa.password2'),
                s_get('payment.method.robokassa.algo'),
                (bool)s_get('payment.method.robokassa.test'),
                $this->app->getLocale() === 'ru' ? RobokassaCheckout::CULTURE_RU : RobokassaCheckout::CULTURE_EN
            );
        });

        $this->app->singleton(InterkassaCheckout::class, function () {
            return new InterkassaCheckout(
                s_get('payment.method.interkassa.checkout_id'),
                s_get('payment.method.interkassa.key'),
                s_get('payment.method.interkassa.test_key'),
                (bool)s_get('payment.method.interkassa.test'),
                s_get('payment.method.interkassa.algo')
            );
        });
    }
}
