<?php
declare(strict_types = 1);

namespace App\Services\Auth;

/**
 * Class Roles
 * Defines available roles.
 * @example
 *  $user->hasRole(Roles::ADMIN);
 */
class Roles
{
    public const USER = 'user';

    public const ADMIN = 'admin';

    private function __construct()
    {
    }
}
