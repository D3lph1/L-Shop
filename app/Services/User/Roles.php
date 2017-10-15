<?php
declare(strict_types = 1);

namespace App\Services\User;

use App\Models\Role\RoleInterface;
use App\Models\User\UserInterface;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Traits\ContainerTrait;

/**
 * Class Roles
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Services\User
 */
class Roles
{
    use ContainerTrait;

    /**
     * @var UserInterface
     */
    private $user;

    /**
     * @var RoleInterface[]
     */
    private $roles;

    /**
     * @var RoleRepositoryInterface
     */
    private $roleRepository;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
        $this->roles = $user->getRoles();
        $this->roleRepository = $this->make(RoleRepositoryInterface::class);
    }

    public function inRole(string $roleSlug): bool
    {
        foreach ($this->roles as $role) {
            if ($role->getSlug() === $roleSlug) {
                return true;
            }
        }

        return false;
    }

    public function attach(RoleInterface $role): bool
    {
        $result = $this->roleRepository->attachUser($role->getId(), $this->user->getId());

        if (!$result) {
            return $result;
        }

        $this->roles[] = $role;

        return true;
    }

    public function detach(RoleInterface $role): bool
    {
        $result = $this->roleRepository->detachUser($role->getId(), $this->user->getId());

        if (!$result) {
            return $result;
        }

        foreach ($this->roles as $key => &$value) {
            if ($value->getId() === $role->getId()) {
                unset($this->roles[$key]);
            }
        }

        return true;
    }
}
