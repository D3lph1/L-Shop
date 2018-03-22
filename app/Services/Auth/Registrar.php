<?php
declare(strict_types = 1);

namespace App\Services\Auth;

use App\Services\Auth\Exceptions\EmailAlreadyExistsException;
use App\Services\Auth\Exceptions\UsernameAlreadyExistsException;
use App\Services\Auth\Hashing\Hasher;
use App\Entity\User;
use App\Repository\User\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class Registrar
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var Hasher
     */
    private $hasher;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $em, Hasher $hasher)
    {
        $this->userRepository = $userRepository;
        $this->em = $em;
        $this->hasher = $hasher;
    }

    /**
     * Registers a new user.
     *
     * @param User $user The entity of the new user.
     *
     * @return User
     */
    public function register(User $user): User
    {
        $this->checkUsername($user->getUsername());
        $this->checkEmail($user->getEmail());

        // Create hashed password.
        $user->setPassword($this->hasher->make($user->getPassword()));
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    private function checkUsername(string $username): void
    {
        if ($this->userRepository->findByUsername($username)) {
            throw new UsernameAlreadyExistsException($username);
        }
    }

    private function checkEmail(string $email): void
    {
        if ($this->userRepository->findByEmail($email)) {
            throw new EmailAlreadyExistsException($email);
        }
    }
}
