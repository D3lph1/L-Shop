<?php
declare(strict_types = 1);

namespace App\Services\User\InitStrategies;

use App\Models\User\UserInterface;
use App\Models\Role\RoleInterface;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Cartalyst\Sentinel\Sentinel;

class CommonUserInitStrategy implements InitStrategyInterface
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
        /** @var RoleInterface $userRole */
        $userRole = $this->sentinel->getRoleRepository()->findBySlug('user');

        /** @var UserRepositoryInterface $userRepository */
        $userRepository = $this->sentinel->getUserRepository();

        if (!$userRepository->hasRole($user, $userRole)) {
            /** @var RoleRepositoryInterface $roleRepository */
            $roleRepository = $this->sentinel->getRoleRepository();

            $roleRepository->attachUser($userRole, $user);
        }
    }
}
