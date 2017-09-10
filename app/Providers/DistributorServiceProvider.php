<?php

namespace App\Providers;

use App\Contracts\Distributor;
use App\Exceptions\DistributorNotFoundException;
use App\Exceptions\UnexpectedSettingsValueException;
use Illuminate\Support\ServiceProvider;

/**
 * Class DistributorServiceProvider
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Providers
 */
class DistributorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->app->bind('distributor', function () {
            $distributor = s_get('distributor.name');
            $full = "App\\Services\\Distributors\\$distributor";
            if (class_exists($full)) {
                $obj = $this->app->make($full);

                if (is_a($obj, \App\Services\Distributors\Distributor::class)) {
                    return $obj;
                }

                throw new \LogicException(
                    "Class $full must be a subclass of " . \App\Services\Distributors\Distributor::class
                );
            }

            throw new DistributorNotFoundException($distributor);
        });
    }
}
