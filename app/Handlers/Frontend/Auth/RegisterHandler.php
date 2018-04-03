<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Auth;

use App\DataTransferObjects\Frontend\Auth\RegisterResult;
use App\Entity\User;
use App\Services\Auth\Auth;
use App\Services\Auth\Checkpoint\ActivationCheckpoint;
use App\Services\Auth\Checkpoint\Pool;

class RegisterHandler
{
    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var Pool
     */
    private $pool;

    public function __construct(Auth $auth, Pool $pool)
    {
        $this->auth = $auth;
        $this->pool = $pool;
    }

    public function handle(string $username, string $email, string $password): RegisterResult
    {
        $user = $this->auth->register(new User($username, $email, $password), false, false, false);
        $dto = new RegisterResult($user, !$this->pool->has(ActivationCheckpoint::NAME));

        return $dto;
    }
}
