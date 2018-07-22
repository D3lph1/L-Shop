<?php
declare(strict_types = 1);

namespace App\Providers;

use App\Exceptions\UnexpectedValueException;
use App\Services\Purchasing\Distributors\Distributor;
use App\Services\Purchasing\Distributors\Pool as DistributorsPool;
use App\Services\Purchasing\Distributors\RconDistribution\CommandBuilder;
use App\Services\Purchasing\Distributors\RconDistribution\Commands;
use App\Services\Purchasing\Distributors\RconDistribution\Connections;
use App\Services\Purchasing\Distributors\RconDistribution\ExtraCommands;
use App\Services\Purchasing\Distributors\RconDistributor;
use App\Services\Purchasing\Payers\InterkassaPayer;
use App\Services\Purchasing\Payers\Payer;
use App\Services\Purchasing\Payers\Pool;
use App\Services\Purchasing\Payers\RobokassaPayer;
use App\Services\Purchasing\Payments\Interkassa\Checkout as InterkassaCheckout;
use App\Services\Purchasing\Payments\Robokassa\Checkout as RobokassaCheckout;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;
use D3lph1\MinecraftRconManager\Connector;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
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
        $this->registerRconDistributionServices();
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

            $currency = $settings->get('purchasing.services.interkassa.currency')->getValue();
            if (empty($currency)) {
                $currency = null;
            }

            /** @noinspection PhpStrictTypeCheckingInspection */
            return new InterkassaPayer(
                $this->app->make(InterkassaCheckout::class),
                $settings->get('purchasing.services.interkassa.enabled')->getValue(DataType::BOOL),
                $currency
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
            foreach ($this->app->make(Repository::class)->get('purchasing.distribution.distributors') as $distributor) {
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

    private function registerRconDistributionServices(): void
    {
        $this->app->singleton(Commands::class, function (Application $app) {
            $config = $app->make(Repository::class);

            return (new Commands())
                ->setGiveNonEnchantedItemCommand($config->get('purchasing.distribution.rcon.commands.give_non_enchanted_item'))
                ->setGiveEnchantedItemCommand($config->get('purchasing.distribution.rcon.commands.give_enchanted_item'))
                ->setGiveNonExpiredPermgroupCommand($config->get('purchasing.distribution.rcon.commands.give_non_expired_permgroup'))
                ->setGiveExpiredPermgroupCommand($config->get('purchasing.distribution.rcon.commands.give_expired_permgroup'))
                ->setGiveCurrencyCommand($config->get('purchasing.distribution.rcon.commands.give_currency'))
                ->setAddRegionOwnerCommand($config->get('purchasing.distribution.rcon.commands.add_region_owner'))
                ->setAddRegionMemberCommand($config->get('purchasing.distribution.rcon.commands.add_region_member'));
        });

        $this->app->singleton(ExtraCommands::class, function (Application $app) {
            $config = $app->make(Repository::class);

            return (new ExtraCommands())
                ->setExtraBeforeCommands($config->get('purchasing.distribution.rcon.extra.before'))
                ->setExtraAfterCommands($config->get('purchasing.distribution.rcon.extra.after'));
        });

        $this->app->singleton(Connections::class, function (Application $app) {
            $config = $app->make(Repository::class);

            return new Connections(
                $app->make(Connector::class),
                $config->get('purchasing.distribution.rcon.timeout')
            );
        });

        $this->app->singleton(RconDistributor::class, function (Application $app) {
            $config = $app->make(Repository::class);

            return new RconDistributor(
                $app->make(CommandBuilder::class),
                $config->get('purchasing.distribution.rcon.success_response'),
                $app->make(Dispatcher::class)
            );
        });
    }
}
