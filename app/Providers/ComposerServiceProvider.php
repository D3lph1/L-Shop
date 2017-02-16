<?php

namespace App\Providers;

use App\Composers\ShopLayoutComposer;
use Illuminate\Support\ServiceProvider;

/**
 * Class ComposerServiceProvider
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Providers
 */
class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer([
            'layouts.shop',
            'shop.catalog',
            'shop.cart'
        ], ShopLayoutComposer::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
