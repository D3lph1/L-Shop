<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Frontend\Auth;

use App\Entity\User;

class LoginResult
{
    /**
     * @var bool
     */
    private $successfully;

    /**
     * @var User|null
     */
    private $user;

    public function __construct(bool $successfully, ?User $user)
    {
        $this->successfully = $successfully;
        $this->user = $user;
    }

    public function isSuccessfully(): bool
    {
        return $this->successfully;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
}
