<?php
declare(strict_types = 1);

namespace App\TransactionScripts;

use App\Events\UserWasRegistered;
use App\Exceptions\User\AlreadyActivatedException;
use App\Exceptions\User\EmailAlreadyExistsException;
use App\Exceptions\User\UnableToCreateUser;
use App\Exceptions\User\UsernameAlreadyExistsException;
use App\Models\User\UserInterface;
use App\Services\User\InitStrategies\AdminInitStrategy;
use App\Services\User\InitStrategies\CommonUserInitStrategy;
use App\Services\User\InitStrategies\InitStrategyInterface;
use App\Traits\ContainerTrait;
use Cartalyst\Sentinel\Sentinel;
use Psr\Log\LoggerInterface;

/**
 * Class Authentication
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\TransactionScripts
 */
class Authentication
{
    use ContainerTrait;

    /**
     * @var Sentinel
     */
    private $sentinel;

    public function __construct(Sentinel $sentinel)
    {
        $this->sentinel = $sentinel;
    }

    public function authenticate(string $username, string $password): ?UserInterface
    {
        /** @var UserInterface $result */
        $result = $this->sentinel->authenticate(compact('username', 'password'), true);

        return $result ?: null;
    }

    /**
     * Register new user in a system.
     *
     * @param string $username      New user username.
     * @param string $email         New user email.
     * @param string $password      New user plain password.
     * @param int    $balance       Starting user balance.
     * @param bool   $admin         Is new user admin?
     * @param bool   $forceActivate Activate the user without confirming the email address.
     *
     * @throws UsernameAlreadyExistsException
     * @throws EmailAlreadyExistsException
     * @throws UnableToCreateUser
     */
    public function register(string $username, string $email, string $password, float $balance = 0, bool $forceActivate = false, bool $admin = false)
    {
        $this->findByUsername($username);
        $this->findByEmail($email);

        $this->create($username, $email, $password, $balance, $forceActivate, $admin);
    }

    /**
     * Check for the existence user with given username.
     *
     * @param string $username
     *
     * @throws UsernameAlreadyExistsException
     */
    private function findByUsername(string $username)
    {
        if ($this->sentinel->getUserRepository()->findByCredentials(['username' => $username])) {
            throw new UsernameAlreadyExistsException($username);
        }
    }

    /**
     * Check for the existence user with given email.
     *
     * @param string $email
     *
     * @throws EmailAlreadyExistsException
     */
    private function findByEmail(string $email)
    {
        if ($this->sentinel->getUserRepository()->findByCredentials(['email' => $email])) {
            throw new EmailAlreadyExistsException($email);
        }
    }

    /**
     * Insert new user in database and activate it if necessary.
     *
     * @param string $username
     * @param string $email
     * @param string $password
     * @param int    $balance
     * @param bool   $admin
     * @param bool   $forceActivate
     *
     * @throws UnableToCreateUser
     */
    private function create(string $username, string $email, string $password, float $balance, bool $forceActivate, bool $admin)
    {
        $credentials = [
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'balance' => $balance
        ];

        try {
            /** @var UserInterface $user */
            $user = $this->sentinel->register($credentials, $forceActivate);
        } catch (\Throwable $e) {
            $this->make(LoggerInterface::class)->error($e);

            throw new UnableToCreateUser();
        }

        if (!$user) {
            $this->make(LoggerInterface::class)->error('Method \Sentinel::register() returned a boolean value');

            throw new UnableToCreateUser();
        }

        if ($admin) {
            /** @var InitStrategyInterface $strategy */
            $strategy = $this->make(AdminInitStrategy::class);
        } else {
            /** @var InitStrategyInterface $strategy */
            $strategy = $this->make(CommonUserInitStrategy::class);
        }
        $strategy->init($user);

        event(new UserWasRegistered($user, !$forceActivate));
    }

    public function activateByUsername(string $username): bool
    {
        /** @var UserInterface $user */
        $user = $this->sentinel->getUserRepository()->findByCredentials(['username' => $username]);

        return $this->activate($user);
    }

    public function activateById(int $userId): bool
    {
        /** @var UserInterface $user */
        $user = $this->sentinel->getUserRepository()->findById($userId);

        return $this->activate($user);
    }

    protected function activate(UserInterface $user): bool
    {
        if ($this->sentinel->getActivationRepository()->completed($user)) {
            throw new AlreadyActivatedException($user->getId());
        }

        return $this->sentinel->activate($user);
    }
}
