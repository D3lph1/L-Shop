<?php
declare(strict_types = 1);

namespace App\Services\Auth;

use App\Services\Auth\Checkpoint\Pool;
use App\Services\Auth\Hashing\Hasher;
use App\Services\Auth\Session\Session;
use App\Services\Auth\Session\SessionPersistence;
use App\Entity\User;
use App\Repository\User\UserRepository;

class Authenticator
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var Hasher
     */
    private $hasher;

    /**
     * @var SessionPersistence
     */
    private $sessionPersistence;

    /**
     * @var Pool
     */
    private $checkpointPool;

    public function __construct(
        UserRepository $userRepository,
        Hasher $hasher,
        SessionPersistence $sessionPersistence,
        Pool $checkpointsPool)
    {
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
        $this->sessionPersistence = $sessionPersistence;
        $this->checkpointPool = $checkpointsPool;
    }

    /**
     * Authenticates the user by the transmitted username and password.
     *
     * @param string $username
     * @param string $password
     * @param bool   $remember If true, the user session will exist even after the browser is closed.
     *
     * @return Session Session object of the authenticated user.
     */
    public function authenticate(string $username, string $password, bool $remember): Session
    {
        $user = $this->userRepository->findByUsername($username);
        if ($user === null) {
            $this->checkpointPool->passLoginFail();

            return $this->emptySession();
        }

        // If passwords are equals.
        if (!$this->hasher->check($password, $user->getPassword())) {
            $this->checkpointPool->passLoginFail();

            return $this->emptySession();
        }

        if (!$this->checkpointPool->passLogin($user)) {
            return $this->emptySession();
        }

        return $this->sessionPersistence->createFromUser($user, $remember);
    }

    /**
     * Produces "quick" user authentication. "Quick" authentication is characterized by
     * the fact that it does not require data from the account (login / password),
     * only the essence of the user is sufficient for it. In addition, this
     * authentication does not call checkpoints.
     *
     * @param User $user User to be authenticated.
     * @param bool $remember If true, the user session will exist even after the browser is closed.
     *
     * @return Session Session object of the authenticated user.
     */
    public function authenticateQuick(User $user, bool $remember): Session
    {
        return $this->sessionPersistence->createFromUser($user, $remember);
    }

    private function emptySession(): Session
    {
        return $this->sessionPersistence->createEmpty();
    }
}
