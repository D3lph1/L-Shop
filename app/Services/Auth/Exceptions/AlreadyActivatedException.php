<?php
declare(strict_types = 1);

namespace App\Services\Auth\Exceptions;

use App\Entity\User;

class AlreadyActivatedException extends AuthException
{
    public function __construct(User $user)
    {
        parent::__construct("User {$user} already activated", 0, null);
    }
}
