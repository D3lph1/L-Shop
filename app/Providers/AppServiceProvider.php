<?php
declare(strict_types = 1);

namespace App\Providers;

use App\Models\Server\ServerInterface;
use App\Services\Activator;
use App\Services\Cart;
use App\Services\Message;
use App\Services\Monitoring\MonitoringInterface;
use App\Services\Monitoring\RconMonitoring;
use App\Services\ReCaptcha;
use App\Services\SashokLauncher;
use D3lph1\MinecraftRconManager\Connector;
use D3lph1\MinecraftRconManager\Rcon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        $this->registerValidators();
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->alias(Message::class, 'message');

        $this->app->alias(Cart::class, 'cart');

        $this->app->bind('recaptcha', function () {
            return new ReCaptcha(
                s_get('recaptcha.public_key'),
                s_get('recaptcha.secret_key')
            );
        });

        $this->app->alias(Activator::class, 'activator');
        $this->app->alias(SashokLauncher::class, 'launcher.sashok');

        $this->app->singleton(Rcon::class, function () {
            return $this->getRconConnector((float)config('l-shop.rcon.timeout'));
        });

        $this->app->alias(Rcon::class, Connector::class);
        $this->app->alias(Rcon::class, 'rcon');

        $this->app->singleton('monitoring.rcon', function () {
            return $this->getRconConnector((float)s_get('monitoring.rcon.timeout'));
        });

        $this->app->singleton(MonitoringInterface::class, function (Application $app) {
            return new RconMonitoring($app->make('monitoring.rcon'));
        });
        $this->app->alias(MonitoringInterface::class, 'monitoring');
    }

    private function getRconConnector(float $timeout): Connector
    {
        // To successfully carry out the migration procedure.
        if (!Schema::hasTable('servers')) {
            return new Connector();
        }

        $servers = $this->app->make('request')->get('servers');
        $connector = new Connector();

        if (!$servers) {
            return $connector;
        }

        /** @var ServerInterface $server */
        foreach ($servers as $server) {
            $connector->add($server->getId(), $server->getIp(), $server->getPort(), $server->getPassword(), $timeout);
        }

        return $connector;
    }

    private function registerValidators()
    {
        Validator::extend('alpha_strict', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-zA-Z]+$/', $value);
        });

        Validator::extend('alpha_dash_strict', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-zA-Z0-9_-]+$/', $value);
        });

        Validator::extend('alpha_num_strict', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-zA-Z0-9]+$/', $value);
        });

        // Checks the input string so that it is a regular regular expression.
        Validator::extend('valid_regex', function ($attribute, $value, $parameters, $validator) {
            try {
                preg_match($value, '');
            } catch (\ErrorException $e) {
                return false;
            }

            return true;
        });
    }
}
