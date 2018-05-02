<?php
declare(strict_types = 1);

namespace App\Exceptions\User;

use App\Exceptions\DomainException;

class UserNotFoundException extends DomainException
{
    public static function byId(int $id): UserNotFoundException
    {
        return new UserNotFoundException("User with id {$id} not found");
    }

    public static function byUsername(string $username): UserNotFoundException
    {
        return new UserNotFoundException("User with username \"{$username}\" not found");
    }

    public static function byEmail(string $email): UserNotFoundException
    {
        return new UserNotFoundException("User with email \"{$email}\" not found");
    }
}
