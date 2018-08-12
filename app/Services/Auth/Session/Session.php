<?php
declare(strict_types = 1);

namespace App\Services\Auth\Session;

use App\Entity\User;

/**
 * Class Session
 * Objects of this class store the state of the user's session. It can be empty
 * (this means that the user has not logged into the account).
 */
class Session
{
    /**
     * Current user.
     * If null - session empty.
     *
     * @var User|null
     */
    private $user;

    public function __construct(?User $user)
    {
        $this->user = $user;
    }

    /**
     * Retrieve current user if it exists.
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Verify whether the user is authenticated.
     *
     * @return bool True - user is authenticated.
     */
    public function check(): bool
    {
        return $this->user !== null;
    }
}
