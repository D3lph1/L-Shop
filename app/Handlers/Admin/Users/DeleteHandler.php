<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Users;

use App\Exceptions\LogicException;
use App\Exceptions\User\UserNotFoundException;
use App\Repository\User\UserRepository;
use App\Services\Auth\Auth;

class DeleteHandler
{
    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(Auth $auth, UserRepository $userRepository)
    {
        $this->auth = $auth;
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $userId
     *
     * @throws UserNotFoundException
     */
    public function handle(int $userId): void
    {
        $user = $this->userRepository->find($userId);
        if ($user === null) {
            throw UserNotFoundException::byId($userId);
        }

        if ($this->auth->getUser()->getId() === $user->getId()) {
            throw new LogicException('Can not delete yourself');
        }

        $this->userRepository->remove($user);
    }
}
