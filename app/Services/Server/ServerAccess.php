<?php
declare(strict_types = 1);

namespace App\Services\Server;

use App\Entity\Server;
use App\Entity\User;
use App\Services\Auth\Permissions;

class ServerAccess
{
    /**
     * Private constructor because this class contains only static methods.
     */
    private function __construct()
    {
    }

    public static function isUserHasAccessTo(?User $user, Server $server): bool
    {
        return ($server->isEnabled() || ($user !== null && $user->hasPermission(Permissions::ACCESS_TO_DISABLED_SERVER)));
    }
}
