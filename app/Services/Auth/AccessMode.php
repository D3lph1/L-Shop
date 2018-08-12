<?php
declare(strict_types = 1);

namespace App\Services\Auth;

/**
 * Class AccessMode
 * Defines allowed types of access to the shop.
 */
class AccessMode
{
    /**
     * Only guests have access.
     */
    public const GUEST = 'guest';

    /**
     * Access is restricted to authorized users only.
     */
    public const AUTH = 'auth';

    /**
     * Access is available to any user.
     */
    public const ANY = 'any';

    /**
     * Private constructor because this class contains only constants.
     */
    private function __construct()
    {
    }
}
