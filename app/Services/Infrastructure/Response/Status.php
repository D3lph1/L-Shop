<?php
declare(strict_types = 1);

namespace App\Services\Infrastructure\Response;

class Status
{
    public const SUCCESS = 'success';

    public const FAILURE = 'failure';

    private function __construct()
    {
    }
}
