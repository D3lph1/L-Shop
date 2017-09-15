<?php
declare(strict_types = 1);

namespace App\Services;

use App\Events\UserWasRegistered;
use App\Exceptions\User\EmailAlreadyExistsException;
use App\Exceptions\User\UnableToCreateUser;
use App\Exceptions\User\UsernameAlreadyExistsException;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Cartalyst\Sentinel\Users\UserInterface;

/**
 * Class Registrar
 * BuyResponse for creating new users
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services
 */
class Registrar
{
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
        if (\Sentinel::getUserRepository()->findByCredentials(['username' => $username])) {
            throw new UsernameAlreadyExistsException();
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
        if (\Sentinel::getUserRepository()->findByCredentials(['email' => $email])) {
            throw new EmailAlreadyExistsException();
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
            $user = \Sentinel::register($credentials, $forceActivate);
        } catch (\Throwable $e) {
            \Log::error($e);

            throw new UnableToCreateUser();
        }

        if (!$user) {
            \Log::error('Method \Sentinel::register() returned a boolean value');

            throw new UnableToCreateUser();
        }

        $this->attachRole($user, $admin);
        event(new UserWasRegistered($user, !$forceActivate));
    }

    /**
     * Attaches a role to a new user.
     *
     * @param UserInterface $user
     * @param bool          $admin
     */
    private function attachRole(UserInterface $user, bool $admin)
    {
        /** @var EloquentRole $adminRole */
        $adminRole = \Sentinel::getRoleRepository()->findBySlug('admin');
        /** @var EloquentRole $userRole */
        $userRole = \Sentinel::getRoleRepository()->findBySlug('user');

        // Detach all roles if user identifier already exists in `role_users` table.
        $adminRole->users()->detach($user);
        $userRole->users()->detach($user);

        if ($admin) {
            $adminRole->users()->attach($user);
        } else {
            $userRole->users()->attach($user);
        }
    }
}
