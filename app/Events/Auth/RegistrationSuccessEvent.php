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

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
