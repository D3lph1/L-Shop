<?php
declare(strict_types = 1);

namespace App\Services\Auth;

class AccessMode
{
    public const GUEST = 'guest';

    public const AUTH = 'auth';

    public const ANY = 'any';

    private function __construct()
    {
    }
}
