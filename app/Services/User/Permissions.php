<?php
declare(strict_types = 1);

namespace App\Services\User;

use App\Models\Role\RoleInterface;
use App\Models\User\UserInterface;

/**
 * Class Permissions
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Services\User
 */
class Permissions
{
    /**
     * @var UserInterface
     */
    private $user;

    /**
     * @var array|null
     */
    private $userPermissions;

    /**
     * @var RoleInterface[]
     */
    private $roles;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
        $this->userPermissions = $user->getPermissions();
        $this->roles = $this->user->getRoles();
    }

    public function hasAccess(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (!$this->check($permission)) {
                return false;
            }
        }

        return true;
    }

    public function hasAnyAccess(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($this->check($permission)) {
                return true;
            }
        }

        return false;
    }

    private function check(string $permission): bool
    {
        foreach ($this->userPermissions as $key => $value) {
            if ((str_is($permission, $key) || str_is($key, $permission)) && $value === true) {
                return true;
            }
        }

        foreach ($this->roles as $role) {
            foreach ($role->getPermissions() as $key => $value) {
                if ((str_is($permission, $key) || str_is($key, $permission)) && $value === true) {
                    return true;
                }
            }
        }

        return false;
    }
}
