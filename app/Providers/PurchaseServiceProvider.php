<?php
declare(strict_types = 1);

namespace App\Providers;

use App\Services\Purchasing\Payers\InterkassaPayer;
use App\Services\Purchasing\Payers\Pool;
use App\Services\Purchasing\Payers\RobokassaPayer;
use App\Services\Purchasing\Payments\Robokassa\Checkout as RobokassaCheckout;
use App\Services\Purchasing\Payments\Interkassa\Checkout as InterkassaCheckout;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;
use Illuminate\Support\ServiceProvider;

class PurchaseServiceProvider extends ServiceProvider
{
    /**
     * Register this available payers.
     *
     * @var array
     */
    private $payers = [
        // Builtin payers...
        RobokassaPayer::class,
        InterkassaPayer::class,

        // Custom payers...
    ];

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
                $settings->get('purchasing.services.interkassa.checkout_id')->getValue(),
                $settings->get('purchasing.services.interkassa.key')->getValue(),
                $settings->get('purchasing.services.interkassa.test_key')->getValue(),
                $settings->get('purchasing.services.interkassa.algorithm')->getValue(),
                $settings->get('purchasing.services.interkassa.test')->getValue(DataType::BOOL)
            );
        });

        $this->app->singleton(RobokassaPayer::class, function () {
            $settings = $this->app->make(Settings::class);

            return new RobokassaPayer(
                $this->app->make(RobokassaCheckout::class),
                $settings->get('purchasing.services.robokassa.enabled')->getValue(DataType::BOOL)
            );
        });

        $this->app->singleton(InterkassaPayer::class, function () {
            $settings = $this->app->make(Settings::class);

            return new InterkassaPayer(
                $this->app->make(InterkassaCheckout::class),
                $settings->get('purchasing.services.interkassa.enabled')->getValue(DataType::BOOL)
            );
        });

        $this->app->singleton(Pool::class, function () {
            return new Pool(array_map(function ($payer) {
                return $this->app->make($payer);
            }, $this->payers));
        });
    }
}
