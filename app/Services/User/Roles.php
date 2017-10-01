<?php
declare(strict_types = 1);

namespace App\Services\User;

use App\Models\Role\RoleInterface;
use App\Models\User\UserInterface;

/**
 * Class Roles
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Services\User
 */
class Roles
{
    /**
     * @var UserInterface
     */
    private $user;

    /**
     * @var RoleInterface[]
     */
    private $roles;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
        $this->roles = $user->getRoles();
    }

    public function inRole(string $roleSlug)
    {
        foreach ($this->roles as $role) {
            if ($role->getSlug() === $roleSlug) {
                return true;
            }
        }

        return false;
    }
}
