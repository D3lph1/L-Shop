<?php
declare(strict_types = 1);

namespace App\Services\Auth\Exceptions;

use App\Entity\User;

class NotActivatedException extends AuthException
{
    private $user;

    public function __construct(User $user)
    {
        parent::__construct("User {$user} not activated", 0, null);
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
