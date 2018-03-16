<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Users\Edit;

use App\DataTransferObjects\Admin\Users\Edit\RenderResult;
use App\DataTransferObjects\Admin\Users\Edit\User;
use App\Entity\Permission;
use App\Entity\Role;
use App\Exceptions\User\DoesNotExistException;
use App\Repository\Permission\PermissionRepository;
use App\Repository\Role\RoleRepository;
use App\Repository\User\UserRepository;
use App\Services\Media\Character\Cloak\Image;

class RenderHandler
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

    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function handle(int $userId): RenderResult
    {
        $user = $this->userRepository->find($userId);
        if ($user === null) {
            throw new DoesNotExistException($userId);
        }

        $cloakExists = Image::exists($user->getUsername());
        $userDTO = new User(
            $user,
            route('api.skin.front', ['username' => $user->getUsername()]),
            route('api.skin.back', ['username' => $user->getUsername()]),
            $cloakExists ? route('api.cloak.front', ['username' => $user->getUsername()]) : null,
            $cloakExists ? route('api.cloak.back', ['username' => $user->getUsername()]) : null
        );

        return new RenderResult($userDTO, $this->roles(), $this->permissions());
    }

    /**
     * @return Role[]
     */
    private function roles(): array
    {
        $roles = [];
        foreach ($this->roleRepository->findByAll() as $role) {
            $roles[] = $role->getName();
        }

        return $roles;
    }

    /**
     * @return Permission[]
     */
    private function permissions(): array
    {
        $permissions = [];
        foreach ($this->permissionRepository->findAll() as $permission) {
            $permissions[] = $permission->getName();
        }

        return $permissions;
    }
}
