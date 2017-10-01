<?php
declare(strict_types = 1);

namespace App\Services\User\InitStrategies;

use App\Models\Role\RoleInterface;
use App\Models\User\UserInterface;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Cartalyst\Sentinel\Sentinel;

class AdminInitStrategy implements InitStrategyInterface
{
    /**
     * @var Sentinel
     */
    private $sentinel;

    public function __construct(Sentinel $sentinel)
    {
        $this->sentinel = $sentinel;
    }

    public function init(UserInterface $user)
    {
        /** @var RoleInterface $adminRole */
        $adminRole = $this->sentinel->getRoleRepository()->findBySlug('admin');

        /** @var RoleInterface $userRole */
        $userRole = $this->sentinel->getRoleRepository()->findBySlug('user');

        /** @var UserRepositoryInterface $userRepository */
        $userRepository = $this->sentinel->getUserRepository();

        if (!$userRepository->hasRole($user, $adminRole)) {
            /** @var RoleRepositoryInterface $roleRepository */
            $roleRepository = $this->sentinel->getRoleRepository();

            $roleRepository->attachUser($userRole, $user);
            $roleRepository->attachUser($adminRole, $user);
        }
    }
}
