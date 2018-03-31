<?php
declare(strict_types = 1);

namespace App\Providers;

use App\Services\Purchasing\Payments\Robokassa\Checkout as RobokassaCheckout;
use App\Services\Purchasing\Payments\Interkassa\Checkout as InterkassaCheckout;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;
use Illuminate\Support\ServiceProvider;

class PurchaseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerServices();
    }

    private function registerServices(): void
    {
        $this->app->singleton(RobokassaCheckout::class, function () {
            $settings = $this->app->make(Settings::class);
            /** @noinspection PhpStrictTypeCheckingInspection */
            return new RobokassaCheckout(
                $settings->get('purchasing.services.robokassa.login')->getValue(),
                $settings->get('purchasing.services.robokassa.payment_password')->getValue(),
                $settings->get('purchasing.services.robokassa.validation_password')->getValue(),
                $settings->get('purchasing.services.robokassa.algorithm')->getValue(),
                $settings->get('purchasing.services.robokassa.test')->getValue(DataType::BOOL),
                $settings->get('purchasing.services.robokassa.culture')->getValue()
            );
        });
        $this->app->singleton(InterkassaCheckout::class, function () {
            $settings = $this->app->make(Settings::class);
            /** @noinspection PhpStrictTypeCheckingInspection */
            return new InterkassaCheckout(
                $settings->get('purchasing.services.interkassa.login')->getValue(),
                $settings->get('purchasing.services.interkassa.key')->getValue(),
                $settings->get('purchasing.services.interkassa.test_key')->getValue(),
                $settings->get('purchasing.services.interkassa.algorithm')->getValue(),
                $settings->get('purchasing.services.interkassa.test')->getValue(DataType::BOOL)
            );
        });
    }
}
