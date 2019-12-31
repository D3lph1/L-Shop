<?php
declare(strict_types = 1);

namespace App\Services\Utils;

final class EnvironmentUtil
{
    public const DB_CONNECTION_MYSQL = 'mysql';

    public const DB_CONNECTION_POSTGRESQL = 'pgsql';

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
