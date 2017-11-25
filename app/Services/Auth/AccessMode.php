<?php
declare(strict_types = 1);

namespace App\Services\Auth;

/**
 * Class AccessMode
 * Defines allowed types of access to the shop.
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Services\Auth
 */
final class AccessMode
{
    /**
     * Access is restricted to authorized users only.
     */
    public const AUTH = 'auth';

    /**
     * Only guests have access.
     */
    public const GUEST = 'guest';

    /**
     * Access is available to any user.
     */
    public const ANY = 'any';

    private function __construct()
    {
        //
    }
}
