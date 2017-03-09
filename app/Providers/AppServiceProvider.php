<?php

namespace App\Providers;

use App\Services\Activator;
use App\Services\Cart;
use App\Services\Message;
use App\Services\QueryManager;
use App\Services\ReCaptcha;
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
    }
}
