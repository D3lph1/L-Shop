<?php
declare(strict_types = 1);

namespace App\Services\Auth;

use App\Entity\User;

interface Registrar
{
    /**
     * Registers a new user.
     *
     * @param User $user The entity of the new user.
     *
     * @return User
     */
    public function register(User $user): User;
}
