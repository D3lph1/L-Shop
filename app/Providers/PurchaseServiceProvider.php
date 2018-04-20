<?php
declare(strict_types = 1);

namespace App\Providers;

use App\Exceptions\UnexpectedValueException;
use App\Services\Purchasing\Distributors\Distributor;
use App\Services\Purchasing\Distributors\Pool as DistributorsPool;
use App\Services\Purchasing\Payers\InterkassaPayer;
use App\Services\Purchasing\Payers\Payer;
use App\Services\Purchasing\Payers\Pool;
use App\Services\Purchasing\Payers\RobokassaPayer;
use App\Services\Purchasing\Payments\Interkassa\Checkout as InterkassaCheckout;
use App\Services\Purchasing\Payments\Robokassa\Checkout as RobokassaCheckout;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;
use Illuminate\Contracts\Config\Repository;
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
                $settings->get('purchasing.services.interkassa.checkout_id')->getValue(),
                $settings->get('purchasing.services.interkassa.key')->getValue(),
                $settings->get('purchasing.services.interkassa.test_key')->getValue(),
                $settings->get('purchasing.services.interkassa.algorithm')->getValue(),
                $settings->get('purchasing.services.interkassa.test')->getValue(DataType::BOOL)
            );
        });


        $this->registerPayers();
        $this->registerPayersPool();
        $this->registerDistributorsPool();
    }

    private function registerPayers(): void
    {
        $this->app->singleton(RobokassaPayer::class, function () {
            $settings = $this->app->make(Settings::class);

            /** @noinspection PhpStrictTypeCheckingInspection */
            return new RobokassaPayer(
                $this->app->make(RobokassaCheckout::class),
                $settings->get('purchasing.services.robokassa.enabled')->getValue(DataType::BOOL)
            );
        });

        $this->app->singleton(InterkassaPayer::class, function () {
            $settings = $this->app->make(Settings::class);

            /** @noinspection PhpStrictTypeCheckingInspection */
            return new InterkassaPayer(
                $this->app->make(InterkassaCheckout::class),
                $settings->get('purchasing.services.interkassa.enabled')->getValue(DataType::BOOL)
            );
        });
    }

    private function registerPayersPool(): void
    {
        $this->app->singleton(Pool::class, function () {
            return new Pool(array_map(function ($payer) {
                $instance = $this->app->make($payer);
                if ($instance instanceof Payer) {
                    return $instance;
                }

                throw new UnexpectedValueException(
                    "Payer {$payer} must be implements interface App\Services\Purchasing\Payers\Payer"
                );
            }, $this->app->make(Repository::class)->get('purchasing.payers')));
        });
    }

    private function registerDistributorsPool(): void
    {
        $this->app->singleton(DistributorsPool::class, function () {
            $distributors = [];
            foreach ($this->app->make(Repository::class)->get('purchasing.distributors') as $distributor) {
                $instance = $this->app->make($distributor);
                if ($instance instanceof Distributor) {
                    $distributors[] = $instance;
                } else {
                    throw new UnexpectedValueException(
                        "Distributor {$distributor} must be implements interface App\Services\Purchasing\Distributors\Distributor"
                    );
                }
            }

            return new DistributorsPool($distributors);
        });
    }
}
