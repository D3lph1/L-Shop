<?php
declare(strict_types = 1);

namespace App\Exceptions\Role;

use App\Exceptions\LogicException;

class RoleAlreadyExistsException extends LogicException
{
    public static function withName(string $name)
    {
        return new RoleAlreadyExistsException("Role with name \"$name\" already exists");
    }
}
