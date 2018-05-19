<?php
declare(strict_types = 1);

namespace App\Services\Auth;

use App\Services\Auth\Exceptions\EmailAlreadyExistsException;
use App\Services\Auth\Exceptions\UsernameAlreadyExistsException;
use App\Services\Auth\Hashing\Hasher;
use App\Entity\User;
use App\Repository\User\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

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
