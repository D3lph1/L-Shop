<?php

namespace App\Providers;

use App\Models\Server;
use App\Repositories\ServerRepository;
use App\Services\Activator;
use App\Services\Cart;
use App\Services\CartBuy;
use App\Services\CatalogBuy;
use App\Services\Message;
use App\Services\Monitoring\MonitoringInterface;
use App\Services\Monitoring\RconMonitoring;
use App\Services\ReCaptcha;
use App\Services\Registrar;
use App\Services\SashokLauncher;
use D3lph1\MinecraftRconManager\Connector;
use D3lph1\MinecraftRconManager\Rcon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        \Validator::extend('alpha_strict', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-zA-Z]+$/', $value);
        });

        \Validator::extend('alpha_dash_strict', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-zA-Z0-9_-]+$/', $value);
        });

        \Validator::extend('alpha_num_strict', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-zA-Z0-9]+$/', $value);
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (!Schema::hasTable('servers')) {
            return;
        }

        $this->app->alias(Message::class, 'message');

        $this->app->alias(Cart::class, 'cart');

        $this->app->bind('recaptcha', function () {
            return new ReCaptcha(
                s_get('recaptcha.public_key'),
                s_get('recaptcha.secret_key')
            );
        });

        $this->app->alias(Activator::class, 'activator');

        $this->app->alias(Activator::class, 'reminder');

        $this->app->alias(Registrar::class, 'registrar');

        $this->app->alias(CatalogBuy::class,'catalog.buy');

        $this->app->alias(CartBuy::class, 'cart.buy');

        $this->app->alias(SashokLauncher::class, 'launcher.sashok');

        $this->app->singleton(Rcon::class, function (Application $app) {
            $request = $app->make('request');
            $servers = $request->get('servers');

            if (!$servers) {
                $servers = $app->make(ServerRepository::class)->all();
            }

            $rcon = new Connector();

            /** @var Server $server */
            foreach ($servers as $server) {
                $rcon->add($server->id, $server->ip, $server->port, $server->password, s_get('monitoring.rcon.timeout', 1));
            }

            return $rcon;
        });
        $this->app->alias(Rcon::class, Connector::class);
        $this->app->alias(Rcon::class, 'rcon');

        $this->app->singleton(MonitoringInterface::class, function (Application $app) {
            return new RconMonitoring($app->make(Rcon::class));
        });
        $this->app->alias(MonitoringInterface::class, 'monitoring');
    }
}
