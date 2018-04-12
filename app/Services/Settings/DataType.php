<?php
declare(strict_types = 1);

namespace App\Services\Settings;

class DataType
{
    public const BOOL = 'bool';

    public const INT = 'int';

    public const FLOAT = 'float';

    public const JSON = 'json';

    public const SERIALIZED = 'serialized';

    private function __construct()
    {
    }
}
