<?php

namespace App\Services;

use App\Exceptions\User\UsernameAlreadyExistsException;
use App\Exceptions\User\EmailAlreadyExistsException;
use App\Exceptions\User\UnableToCreateUser;
use Cartalyst\Sentinel\Users\UserInterface;
use App\Events\UserWasRegistered;

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
     * Register new user in a system
     *
     * @param string $username
     * @param string $email
     * @param string $password
     * @param int    $balance
     * @param bool   $admin
     * @param bool   $forceActivate
     *
     * @throws UsernameAlreadyExistsException
     * @throws EmailAlreadyExistsException
     * @throws UnableToCreateUser
     */
    public function register($username, $email, $password, $balance = 0, $forceActivate = false, $admin = false)
    {
        $this->findByUsername($username);
        $this->findByEmail($email);

        $this->create($username, $email, $password, $balance, $forceActivate, $admin);
    }

    /**
     * Check for the existence user with given username
     *
     * @param string $username
     *
     * @throws UsernameAlreadyExistsException
     */
    private function findByUsername($username)
    {
        if (\Sentinel::findByCredentials(['username' => $username])) {
            throw new UsernameAlreadyExistsException();
        }
    }

    /**
     * Check for the existence user with given email
     *
     * @param string $email
     *
     * @throws EmailAlreadyExistsException
     */
    private function findByEmail($email)
    {
        if (\Sentinel::findByCredentials(['email' => $email])) {
            throw new EmailAlreadyExistsException();
        }
    }

    /**
     * Insert new user in database and activate it if necessary
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
    private function create($username, $email, $password, $balance, $forceActivate, $admin)
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
            throw new UnableToCreateUser($e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        if (!$user) {
            throw new UnableToCreateUser(
                'Method \Sentinel::register() returned a boolean value'
            );
        }

        $this->attachRole($user, $admin);
        event(new UserWasRegistered($user, !$forceActivate));
    }

    /**
     * Attaches a role to a new user
     *
     * @param UserInterface $user
     * @param bool          $admin
     */
    private function attachRole(UserInterface $user, $admin)
    {
        $adminRole = \Sentinel::findRoleBySlug('admin');
        $userRole = \Sentinel::findRoleBySlug('user');

        // Detach all roles if user keu already exists in `role_users` table
        $adminRole->users()->detach($user);
        $userRole->users()->detach($user);

        if ($admin) {
            $adminRole->users()->attach($user);
        } else {
            $userRole->users()->attach($user);
        }
    }
}
