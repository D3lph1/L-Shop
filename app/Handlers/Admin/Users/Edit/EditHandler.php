<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Users\Edit;

use App\DataTransferObjects\Admin\Users\Edit\Edit;
use App\Entity\User;
use App\Exceptions\User\UserNotFoundException;
use App\Repository\Permission\PermissionRepository;
use App\Repository\Role\RoleRepository;
use App\Repository\User\UserRepository;
use App\Services\Auth\Exceptions\EmailAlreadyExistsException;
use App\Services\Auth\Exceptions\UsernameAlreadyExistsException;
use App\Services\Auth\Hashing\Hasher;

class EditHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * @var PermissionRepository
     */
    private $permissionRepository;

    /**
     * @var Hasher
     */
    private $hasher;

    public function __construct(
        UserRepository $userRepository,
        RoleRepository $roleRepository,
        PermissionRepository $permissionRepository,
        Hasher $hasher)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
        $this->hasher = $hasher;
    }

    /**
     * @param Edit $dto
     *
     * @throws UserNotFoundException
     */
    public function handle(Edit $dto)
    {
        $user = $this->userRepository->find($dto->getUserId());
        if ($user === null) {
            throw UserNotFoundException::byId($dto->getUserId());
        }

        $userByUsername = $this->userRepository->findByUsername($dto->getUsername());
        if ($userByUsername !== null && $userByUsername->getId() !== $user->getId()) {
            throw new UsernameAlreadyExistsException($dto->getUsername());
        }

        $userByEmail = $this->userRepository->findByEmail($dto->getEmail());
        if ($userByEmail !== null && $userByEmail->getId() !== $user->getId()) {
            throw new EmailAlreadyExistsException($dto->getEmail());
        }

        $user
            ->setUsername($dto->getUsername())
            ->setEmail($dto->getEmail());

        if (!empty($dto->getPassword())) {
            $user->setPassword($this->hasher->make($dto->getPassword()));
        }

        $this->updateRoles($user, $dto->getRoles());
        $this->updatePermissions($user, $dto->getPermissions());

        $this->userRepository->update($user);
    }

    private function updateRoles(User $user, array $roles): void
    {
        $roles = $this->roleRepository->findWhereNameIn($roles);
        $old = $user->getRoles();
        // Attach roles.
        foreach ($roles as $role) {
            if ($old->indexOf($role) === false) {
                $role->getUsers()->add($user);
                $user->getRoles()->add($role);
            }
        }

        // Detach roles.
        foreach ($old as $item) {
            $f = false;
            foreach ($roles as $role) {
                if ($role->getId() === $item->getId()) {
                    $f = true;
                }
            }

            if (!$f) {
                $item->getUsers()->removeElement($user);
                $user->getRoles()->removeElement($item);
            }
        }
    }

    private function updatePermissions(User $user, array $permissions): void
    {
        $permissions = $this->permissionRepository->findWhereNameIn($permissions);
        $old = $user->getPermissions();
        // Attach permissions.
        foreach ($permissions as $permission) {
            if ($old->indexOf($permission) === false) {
                $permission->getUsers()->add($user);
                $user->getPermissions()->add($permission);
            }
        }

        // Detach permissions.
        foreach ($old as $item) {
            $f = false;
            foreach ($permissions as $permission) {
                if ($permission->getId() === $item->getId()) {
                    $f = true;
                }
            }

            if (!$f) {
                $item->getUsers()->removeElement($user);
                $user->getPermissions()->removeElement($item);
            }
        }
    }
}
