<?php
declare(strict_types=1);

namespace App\Handlers\Consoe\User\Roles;

use App\DataTransferObjects\Commands\User\Roles\RolesList;
use App\Exceptions\User\DoesNotExistException;
use App\Repository\User\UserRepository;

class ListHandler
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
     * @param string $username    The user whose list of roles need to get.
     *
     * @throws DoesNotExistException
     *
     * @return RolesList
     */
    public function handle(string $username): RolesList
    {
        $user = $this->userRepository->findByUsername($username);
        if ($user === null) {
            throw new DoesNotExistException($user);
        }

        return new RolesList($user->getRoles()->toArray(), $user);
    }
}
