<?php

declare(strict_types=1);

namespace App\Services\Database;

use App\Exceptions\RuntimeException;
use App\Services\Database\Query\Postgresql\Day as PostgreSQLDay;
use App\Services\Database\Query\Postgresql\Month as PostgreSQLMonth;
use App\Services\Database\Query\Postgresql\Year as PostgreSQLYear;
use App\Services\Utils\EnvironmentUtil;
use DoctrineExtensions\Query\Mysql\DateFormat as MySQLDateFormat;
use DoctrineExtensions\Query\Mysql\Day as MySQLDay;
use DoctrineExtensions\Query\Mysql\Month as MySQLMonth;
use DoctrineExtensions\Query\Mysql\Year as MySQLYear;
use DoctrineExtensions\Query\Postgresql\DateFormat as PostgreSQLDateFormat;

final class DatabaseUtil
{
    public const CUSTOM_MYSQL_DATETIME_FUNCTIONS = [
        'DATE_FORMAT' => MySQLDateFormat::class,
        'YEAR' => MySQLYear::class,
        'MONTH' => MySQLMonth::class,
        'DAY' => MySQLDay::class
    ];

    public const CUSTOM_POSTGRESQL_DATETIME_FUNCTIONS = [
        'DATE_FORMAT' => PostgreSQLDateFormat::class,
        'YEAR' => PostgreSQLYear::class,
        'MONTH' => PostgreSQLMonth::class,
        'DAY' => PostgreSQLDay::class
    ];

    /**
     * Private constructor because this class contains only static methods.
     */
    private function __construct()
    {
    }

    public static function getCustomDatetimeFunctions(): array
    {
        $connection = env('DB_CONNECTION');

        if ($connection === EnvironmentUtil::DB_CONNECTION_MYSQL) {
            return self::CUSTOM_MYSQL_DATETIME_FUNCTIONS;
        }

        if ($connection === EnvironmentUtil::DB_CONNECTION_POSTGRESQL) {
            return self::CUSTOM_POSTGRESQL_DATETIME_FUNCTIONS;
        }

        throw new RuntimeException(
            "Unsupported connection \"{$connection}\". Supports only \"mysql\" and \"pgsql\"."
        );
    }
}
