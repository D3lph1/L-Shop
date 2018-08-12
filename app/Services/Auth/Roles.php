<?php
declare(strict_types = 1);

namespace App\Services\Auth;

/**
 * Class Roles
 * Defines available roles.
 * <p>For example:</p>
 * <code>
 *  $user->hasRole(Roles::ADMIN);
 * </code>
 */
class Roles
{
    public const USER = 'user';

    public const ADMIN = 'admin';

    /**
     * Private constructor because this class contains only constants.
     */
    private function __construct()
    {
    }
}
