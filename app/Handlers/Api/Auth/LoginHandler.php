<?php
declare(strict_types = 1);

namespace App\Handlers\Api\Auth;

use App\Exceptions\ForbiddenException;
use App\Exceptions\User\UserNotFoundException;
use App\Repository\User\UserRepository;
use App\Services\Auth\Auth;
use App\Services\Auth\Checkpoint\Pool;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;

class LoginHandler
{
    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var Pool
     */
    private $checkpoints;

    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @var Settings
     */
    private $settings;

    public function __construct(Auth $auth, Pool $checkpoints, UserRepository $repository, Settings $settings)
    {
        $this->auth = $auth;
        $this->checkpoints = $checkpoints;
        $this->repository = $repository;
        $this->settings = $settings;
    }

    /**
     * @param string $username
     * @param bool   $remember
     * @param bool   $withoutCheckpoints
     *
     * @return bool
     * @throws ForbiddenException
     * @throws UserNotFoundException
     */
    public function handle(string $username, bool $remember, bool $withoutCheckpoints): bool
    {
        if (!$this->settings->get('api.login_enabled')->getValue(DataType::BOOL)) {
            throw new ForbiddenException(
                'API authentication is disabled. To enable, set the "api.login" value to true'
            );
        }

        $user = $this->repository->findByUsername($username);
        if ($user === null) {
            throw UserNotFoundException::byUsername($username);
        }

        if ($withoutCheckpoints) {
            $this->checkpoints->disable();
        }

        $result = $this->auth->authenticateQuick($user, $remember);

        if ($withoutCheckpoints) {
            $this->checkpoints->reset();
        }

        return $result;
    }
}
