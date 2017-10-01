<?php
declare(strict_types = 1);

namespace App\Providers;

use App\Services\Activator;
use App\Services\Cart;
use App\Services\Message;
use App\Services\Monitoring\MonitoringInterface;
use App\Services\Monitoring\RconMonitoring;
use App\Services\ReCaptcha;
use App\Services\SashokLauncher;
use App\TransactionScripts\Monitoring;
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

        $this->app->singleton(Rcon::class, function (Application $app) {
            // To successfully carry out the migration procedure.
            if (!Schema::hasTable('servers')) {
                return new Connector();
            }

            return $this->app->make(Monitoring::class)->init($app->make('request')->get('servers'));
        });

        $this->app->alias(Rcon::class, Connector::class);
        $this->app->alias(Rcon::class, 'rcon');
        $this->app->singleton(MonitoringInterface::class, function (Application $app) {
            return new RconMonitoring($app->make(Rcon::class));
        });
        $this->app->alias(MonitoringInterface::class, 'monitoring');
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
    }
}
