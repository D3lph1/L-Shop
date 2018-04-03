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

    /**
     * Authenticates the user by the transmitted username and password.
     *
     * @param string $username
     * @param string $password
     * @param bool   $remember If true, the user session will exist even after the browser is closed.
     *
     * @return bool User authentication result.
     */
    public function authenticate(string $username, string $password, bool $remember = false): bool
    {
        $this->session = $this->authenticator->authenticate($username, $password, $remember);

        return $this->session->check();
    }

    /**
     * Registers a new user in the system.
     *
     * @param User $user         Entity of new user.
     * @param bool $activate     If true, the user will be activated immediately after registration.
     * @param bool $authenticate Authenticate the user after registration.
     * @param bool $remember     If true and $authenticate is true, the user session will exist
     *                           even after the browser is closed.
     *
     * @return User
     * @throws \Exception
     */
    public function register(User $user, bool $activate = false, bool $authenticate = false, bool $remember = false): User
    {
        $this->eventDispatcher->dispatch(new RegistrationBeginEvent());
        try {
            $user = $this->registrar->register($user);
        } catch (\Exception $e) {
            $this->eventDispatcher->dispatch(new RegistrationFailedEvent());

            throw $e;
        }
        $this->eventDispatcher->dispatch(new RegistrationSuccessEvent($user, $activate));
        if ($authenticate) {
            $this->session = $this->authenticator->authenticateQuick($user, $remember);
        }

        return $user;
    }

    /**
     * Returns the user stored in the session, otherwise - null.
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        $this->setSessionIfNeed();

        return $this->session->getUser();
    }

    /**
     * Checks if the session is not empty.
     *
     * @return bool
     */
    public function check(): bool
    {
        $this->setSessionIfNeed();

        return $this->session->check();
    }

    /**
     * Deletes the user by destroying the session on the current device.
     *
     * @param bool $anywhere If true - destroys user sessions on all devices.
     */
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
