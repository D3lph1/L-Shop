<?php

namespace App\Providers;

use App\Services\Cart;
use App\Services\Message;
use App\Services\QueryManager;
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

        $this->app->bind('msg', function () {
            return new Message();
        });

        $this->app->singleton('cart', function () {
            return new Cart();
        });
    }
}
