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
     *
     * @return void
     */
    public function boot()
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
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('message', function () {
            return new Message();
        });

        $this->app->bind('cart', function () {
            return new Cart();
        });

        $this->app->bind('recaptcha', function () {
            return new ReCaptcha(
                s_get('recaptcha.public_key'),
                s_get('recaptcha.secret_key')
            );
        });

        $this->app->bind('activator', function () {
            return new Activator();
        });

        $this->app->bind('reminder', function () {
            return new Activator();
        });

        $this->app->bind('registrar', function () {
            return new Registrar();
        });

        $this->app->bind('catalog.buy', function () {
            return new CatalogBuy();
        });

        $this->app->bind('cart.buy', function () {
            return new CartBuy();
        });

        $this->app->bind('launcher.sashok', function () {
            return new SashokLauncher();
        });

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
