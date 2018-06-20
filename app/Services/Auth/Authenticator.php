<?php
declare(strict_types = 1);

namespace App\Services\Auth;

use App\Entity\User;
use App\Services\Auth\Session\Session;

interface Authenticator
{
    /**
     * Authenticates the user by the transmitted username and password.
     *
     * @param string $username
     * @param string $password
     * @param bool   $remember If true, the user session will exist even after the browser is closed.
     *
     * @return Session Session object of the authenticated user.
     */
    public function authenticate(string $username, string $password, bool $remember): Session;

    /**
     * Produces "quick" user authentication. "Quick" authentication is characterized by
     * the fact that it does not require data from the account (login / password),
     * only the essence of the user is sufficient for it. Checkpoints will still
     * be called.
     *
     * @param User $user User to be authenticated.
     * @param bool $remember If true, the user session will exist even after the browser is closed.
     *
     * @return Session Session object of the authenticated user.
     */
    public function authenticateQuick(User $user, bool $remember): Session;
}
