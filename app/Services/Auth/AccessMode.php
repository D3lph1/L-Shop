<?php
declare(strict_types = 1);

namespace App\Services\Auth;

/**
 * Class AccessMode
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Services\Auth
 */
final class AccessMode
{
    public const AUTH = 'auth';

    public const GUEST = 'guest';

    public const ANY = 'any';

    private function __construct()
    {
        //
    }
}
