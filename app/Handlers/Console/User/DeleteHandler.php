<?php
declare(strict_types = 1);

namespace App\Handlers\Consoe\User;

use App\Exceptions\User\UserNotFoundException;
use App\Repository\User\UserRepository;

class DeleteHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $username User who needs to check on existing.
     *
     * @return bool
     */
    public function check(string $username): bool
    {
        return $this->userRepository->findByUsername($username) !== null;
    }

    /**
     * @param string $username User who needs to delete. User is identified by username.
     *
     * @throws UserNotFoundException
     */
    public function handle(string $username)
    {
        $user = $this->userRepository->findByUsername($username);
        if ($user === null) {
            throw UserNotFoundException::byUsername($username);
        }

        $this->userRepository->remove($user);
    }
}
