<?php
declare(strict_types = 1);

namespace App\Exceptions\Role;

use App\Exceptions\DomainException;
use Throwable;

class RoleNotFoundException extends DomainException
{
    public static function byName(string $name): RoleNotFoundException
    {
        return new RoleNotFoundException("Role with name \"{$name}\" not found");
    }
}
