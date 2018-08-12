<?php
declare(strict_types = 1);

namespace App\Services\Utils;

class EnvironmentUtil
{
    /**
     * Private constructor because this class contains only static methods.
     */
    private function __construct()
    {
    }

    /**
     * Check app env on production.
     *
     * @return bool
     */
    public static function inProduction(): bool
    {
        $env = env('APP_ENV');

        return $env === 'production' || $env === 'prod';
    }

    /**
     * Check app env on development.
     *
     * @return bool
     */
    public static function inDevelopment(): bool
    {
        $env = env('APP_ENV');

        return $env === 'development' || $env === 'dev' || $env === 'local';
    }
}
