<?php
declare(strict_types = 1);

namespace App\Services\Auth\Exceptions;

class ThrottlingException extends AuthException
{
    /**
     * @var int
     */
    private $cooldownRemaining;

    public function __construct(int $cooldownRemaining)
    {
        parent::__construct("The possibility of authentication is temporarily blocked due to a large number of unsuccessful attempts");
        $this->cooldownRemaining = $cooldownRemaining;
    }

    /**
     * @return int
     */
    public function getCooldownRemaining(): int
    {
        return $this->cooldownRemaining;
    }
}
