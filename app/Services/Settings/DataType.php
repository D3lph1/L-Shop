<?php
declare(strict_types = 1);

namespace App\Services\Settings;

/**
 * Class DataType
 * Represents constants for storing data types. Used to convert the received settings data.
 */
class DataType
{
    public const BOOL = 'bool';

    public const INT = 'int';

    public const FLOAT = 'float';

    public const JSON = 'json';

    public const SERIALIZED = 'serialized';

    /**
     * Private constructor because this class contains only constants.
     */
    private function __construct()
    {
    }
}
