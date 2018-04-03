<?php
declare(strict_types=1);

namespace App\Handlers\Consoe\User\Roles;

use App\Exceptions\Role\DoesNotExistException as RoleDoesNotExistException;
use App\Exceptions\User\DoesNotExistException as UserDoesNotExistException;
use App\Exceptions\User\RoleAlreadyAttachedException;
use App\Repository\Role\RoleRepository;
use App\Repository\User\UserRepository;

class AttachHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var RoleRepository
     */
    private $roleRepository;

    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param string $username User who needs to assign a roles. User is identified by username.
     * @param array      $roles    Roles that will be attached to the user. Roles are identified by name.
     *
     * @throws UserDoesNotExistException
     * @throws RoleDoesNotExistException
     * @throws RoleAlreadyAttachedException
     */
    public function handle(string $username, array $roles)
    {
        $user = $this->userRepository->findByUsername($username);

        if ($user === null) {
            throw new UserDoesNotExistException($user);
        }

        $rs = $this->roleRepository->findWhereNameIn($roles);
        // Checking that all the passed roles really exist.
        foreach ($roles as $role) {
            $f = true;
            foreach ($rs as $each) {
                if ($each->getName() === $role) {
                    $f = false;
                    break;
                }

            }

            if ($f) {
                throw new RoleDoesNotExistException($role);
            }
        }

        foreach ($rs as $role) {
            if ($user->hasRole($role)) {
                throw new RoleAlreadyAttachedException($role);
            }

            $user->getRoles()->add($role);
            $role->getUsers()->add($user);
        }

        $this->userRepository->update($user);
    }
}
