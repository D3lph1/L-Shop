<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Auth;

use App\DataTransferObjects\Frontend\Auth\LoginResult;
use App\Services\Auth\Auth;

class AuthHandler
{
    /**
     * @var Auth
     */
    private $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle(string $username, string $password, bool $remember): LoginResult
    {
        $result = $this->auth->authenticate($username, $password, $remember);

        return new LoginResult($result, $this->auth->getUser());
    }
}
