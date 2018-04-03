<?php
declare(strict_types = 1);

namespace App\Events\Auth;

use App\Entity\User;

class RegistrationSuccessEvent
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var bool
     */
    private $needActivate;

    public function __construct(User $user, bool $needActivate)
    {
        $this->user = $user;
        $this->needActivate = $needActivate;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function isNeedActivate(): bool
    {
        return $this->needActivate;
    }
}
