<?php
declare(strict_types=1);

namespace App\Handlers\Consoe\User\Roles;

use App\Entity\Role;
use App\Exceptions\Role\DoesNotExistException as RoleDoesNotExistException;
use App\Exceptions\User\DoesNotExistException as UserDoesNotExistException;
use App\Repository\Role\RoleRepository;
use App\Repository\User\UserRepository;

class DetachHandler
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
     * @param string $username User who needs to detach a roles. User is identified by username.
     * @param array      $roles    Roles that will be detached from the user. Roles are identified by name.
     *
     * @throws UserDoesNotExistException
     * @throws RoleDoesNotExistException
     */
    public function handle(string $username, array $roles)
    {
        $user = $this->userRepository->findByUsername($username);
        if ($user === null) {
            throw new UserDoesNotExistException($user);
        }

        /** @var Role[] $rs */
        $rs = $user->getRoles();
        foreach ($roles as $role) {
            $f = true;
            foreach ($rs as $each) {
                if ($each->getName() === $role) {
                    $f = false;
                    $each->getUsers()->removeElement($user);
                    $user->getRoles()->removeElement($each);
                    break;
                }
            }

            if ($f) {
                throw new RoleDoesNotExistException($role);
            }
        }

        $this->userRepository->update($user);
    }
}
