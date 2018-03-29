<?php
declare(strict_types = 1);

namespace App\Services\Infrastructure\Response;

class Status
{
    public const SUCCESS = 'success';

    public const FAILURE = 'failure';

    public const FORBIDDEN = 'forbidden';

    private function __construct()
    {
    }
}
