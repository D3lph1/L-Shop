<?php
declare(strict_types = 1);

namespace App\Services\Auth\Session;

use App\Entity\User;

class Session
{
    /**
     * @var User|null
     */
    private $user;

    public function __construct(?User $user)
    {
        $this->user = $user;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function check(): bool
    {
        return $this->user !== null;
    }
}
