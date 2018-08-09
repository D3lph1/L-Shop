<?php
declare(strict_types = 1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Factory;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Factory $factory
     *
     * @return void
     */
    public function boot(Factory $factory): void
    {
        $factory->extend('alpha_strict', function ($attribute, $value) {
            return preg_match('/^[a-zA-Z]+$/', $value);
        });

        $factory->extend('alpha_dash_strict', function ($attribute, $value) {
            return preg_match('/^[a-zA-Z0-9_-]+$/', $value);
        });

        $factory->extend('alpha_num_strict', function ($attribute, $value) {
            return preg_match('/^[a-zA-Z0-9]+$/', $value);
        });

        // Checks the input string so that it is a regular regular expression.
        $factory->extend('valid_regex', function ($attribute, $value) {
            try {
                preg_match($value, '');
            } catch (\ErrorException $e) {
                return false;
            }

            return true;
        });

        $factory->extend('not_regex', function ($attribute, $value, $parameters) {
            return preg_match($parameters[0], $value) === 0;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }
}
