<?php

namespace App\Providers;

use App\Services\Activator;
use App\Services\Cart;
use App\Services\CartBuy;
use App\Services\CatalogBuy;
use App\Services\Message;
use App\Services\QueryManager;
use App\Services\ReCaptcha;
use App\Services\Registrar;
use App\Services\SashokLauncher;
use Carbon\Carbon;
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
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('qm', function () {
            return new QueryManager();
        });

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

        $this->app->bind('catalog.buy', function (Application $app) {
            return new CatalogBuy();
        });

        $this->app->bind('cart.buy', function (Application $app) {
            return new CartBuy();
        });

        $this->app->bind('launcher.sashok', function () {
            return new SashokLauncher();
        });
    }
}
