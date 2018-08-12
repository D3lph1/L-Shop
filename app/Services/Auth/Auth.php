<?php
declare(strict_types = 1);

namespace App\Services\Auth;

use App\Entity\User;

interface Auth
{
    /**
     * Authenticates the user by the transmitted username and password.
     *
     * @param string $username
     * @param string $password
     * @param bool   $remember If true, the user session will exist even after the browser is closed.
     *
     * @return bool User authentication result.
     */
    public function authenticate(string $username, string $password, bool $remember = false): bool;

    /**
     * Authenticate user from given object.
     *
     * @param User $user     A user whose login session is required to create.
     * @param bool $remember If true, the user session will exist even after the browser is closed.
     *
     * @return mixed
     * @see Authenticator::authenticateQuick()
     */
    public function authenticateQuick(User $user, bool $remember): bool;

    /**
     * Registers a new user in the system.
     *
     * @param User $user     Entity of new user.
     * @param bool $activate If true, the user will be activated immediately after registration.
     *
     * @return User
     * @throws \Exception
     */
    public function register(User $user, bool $activate = false): User;

    /**
     * Returns the user stored in the session, otherwise - null.
     *
     * @return User|null
     */
    public function getUser(): ?User;

    /**
     * Checks if the session is not empty.
     *
     * @return bool
     */
    public function check(): bool;

    /**
     * Deletes the user by destroying the session on the current device.
     *
     * @param bool $anywhere If true - destroys user sessions on all devices.
     */
    public function logout(bool $anywhere = false): void;
}
