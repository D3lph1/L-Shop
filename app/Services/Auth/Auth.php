<?php
declare(strict_types=1);

namespace App\Services\Auth;

use App\Services\Auth\Checkpoint\Pool;
use App\Services\Auth\Session\Session;
use App\Services\Auth\Session\SessionPersistence;
use App\Entity\User;
use App\Events\Auth\RegistrationBeginEvent;
use App\Events\Auth\RegistrationFailedEvent;
use App\Events\Auth\RegistrationSuccessEvent;
use Illuminate\Events\Dispatcher;

class Auth
{
    /**
     * @var Authenticator
     */
    private $authenticator;

    /**
     * @var Registrar
     */
    private $registrar;

    /**
     * @var SessionPersistence
     */
    private $sessionPersistence;

    /**
     * @var Dispatcher
     */
    private $eventDispatcher;

    /**
     * @var Pool
     */
    private $pool;

    /**
     * @var Session
     */
    private $session = null;

    public function __construct(
        Authenticator $authenticator,
        Registrar $registrar,
        SessionPersistence $sessionPersistence,
        Dispatcher $dispatcher,
        Pool $pool)
    {
        $this->authenticator = $authenticator;
        $this->registrar = $registrar;
        $this->sessionPersistence = $sessionPersistence;
        $this->eventDispatcher = $dispatcher;
        $this->pool = $pool;
    }

    public function authenticate(string $username, string $password, bool $remember = false): bool
    {
        $this->session = $this->authenticator->authenticate($username, $password, $remember);

        return $this->session->check();
    }

    public function register(User $user, bool $authenticate = false, bool $remember = false): User
    {
        $this->eventDispatcher->dispatch(new RegistrationBeginEvent());
        try {
            $user = $this->registrar->register($user);
        } catch (\Exception $e) {
            $this->eventDispatcher->dispatch(new RegistrationFailedEvent());

            throw $e;
        }
        $this->eventDispatcher->dispatch(new RegistrationSuccessEvent($user));
        if ($authenticate) {
            $this->session = $this->authenticator->authenticateQuick($user, $remember);
        }

        return $user;
    }

    public function getUser(): ?User
    {
        $this->setSessionIfNeed();

        return $this->session->getUser();
    }

    public function check(): bool
    {
        $this->setSessionIfNeed();

        return $this->session->check();
    }

    public function logout(bool $anywhere = false): void
    {
        $this->pool->disable();
        $this->setSessionIfNeed();
        if ($this->session->check()) {
            $this->sessionPersistence->destroy($this->session->getUser(), $anywhere);
            $this->session = $this->sessionPersistence->createEmpty();
        }
        $this->pool->reset();
    }

    private function setSessionIfNeed(): void
    {
        if ($this->session === null) {
            $this->session = $this->sessionPersistence->createFromPersistenceStorage();
        }
    }
}
