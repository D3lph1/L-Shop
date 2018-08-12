<?php
declare(strict_types = 1);

namespace App\Services\Auth\Exceptions;

class EmailAlreadyExistsException extends AuthException
{
    public function __construct(string $email)
    {
        parent::__construct($email, 0, null);
    }
}
