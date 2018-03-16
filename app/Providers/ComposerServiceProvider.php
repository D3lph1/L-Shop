<?php
declare(strict_types = 1);

namespace App\Providers;

use App\Composers\GlobalLayoutComposer;
use App\Composers\ShopLayoutComposer;
use Illuminate\Support\ServiceProvider;

/**
 * Class ComposerServiceProvider
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Providers
 */
class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        view()->composer(['app'], GlobalLayoutComposer::class);
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        //
    }
}
