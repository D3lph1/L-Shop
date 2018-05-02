<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Users\Edit;

use App\DataTransferObjects\Admin\Users\Edit\RenderResult;
use App\DataTransferObjects\Admin\Users\Edit\User;
use App\Entity\Permission;
use App\Entity\Role;
use App\Exceptions\User\UserNotFoundException;
use App\Repository\Permission\PermissionRepository;
use App\Repository\Role\RoleRepository;
use App\Repository\User\UserRepository;
use App\Services\Auth\Activator;
use App\Services\Auth\BanManager;
use App\Services\DateTime\Formatting\JavaScriptFormatter;
use App\Services\Media\Character\Cloak\Image as CloakImage;
use App\Services\Media\Character\Skin\Image as SkinImage;

class RenderHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var Activator
     */
    private $activator;

    /**
     * @var BanManager
     */
    private $banManager;

    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * @var PermissionRepository
     */
    private $permissionRepository;

    public function __construct(
        UserRepository $userRepository,
        Activator $activator,
        BanManager $banManager,
        RoleRepository $roleRepository,
        PermissionRepository $permissionRepository)
    {
        $this->userRepository = $userRepository;
        $this->activator = $activator;
        $this->banManager = $banManager;
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @param int $userId
     *
     * @return RenderResult
     * @throws UserNotFoundException
     */
    public function handle(int $userId): RenderResult
    {
        $user = $this->userRepository->find($userId);
        if ($user === null) {
            throw UserNotFoundException::byId($userId);
        }

        $activation = $this->activator->activation($user);
        $activatedAt = $activation !== null ? $activation->getCompletedAt() : null;

        $cloakExists = CloakImage::exists($user->getUsername());
        $userDTO = (new User($user, $this->banManager))
            ->setSkinFront(route('api.skin.front', ['username' => $user->getUsername()]))
            ->setSkinBack(route('api.skin.back', ['username' => $user->getUsername()]))
            ->setCloakFront(route('api.cloak.front', ['username' => $user->getUsername()]))
            ->setCloakBack(route('api.cloak.back', ['username' => $user->getUsername()]))
            ->setSkinDefault(SkinImage::isDefault($user->getUsername()))
            ->setCloakExists($cloakExists)
            ->setActivatedAt((new JavaScriptFormatter())->format($activatedAt))
            ->setBanned($this->banManager->isBanned($user));

        return (new RenderResult())
            ->setUser($userDTO)
            ->setRoles($this->roles())
            ->setPermissions($this->permissions());
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
