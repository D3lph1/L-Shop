<?php
declare(strict_types = 1);

namespace App\Exceptions\User;

use App\Exceptions\DomainException;

class DoesNotExistException extends DomainException
{
    public function __construct($user)
    {
        parent::__construct("User {$user} does not exist", 0, null);
    }
}
