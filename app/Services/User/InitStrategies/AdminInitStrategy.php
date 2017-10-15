<?php
declare(strict_types = 1);

namespace App\Services\User\InitStrategies;

use App\Models\Role\RoleInterface;
use App\Models\User\UserInterface;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Cartalyst\Sentinel\Sentinel;

/**
 * Class AdminInitStrategy
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Services\User\InitStrategies
 */
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

    /**
     * {@inheritdoc}
     */
    public function init(UserInterface $user): void
    {
        /** @var RoleInterface $adminRole */
        $adminRole = $this->sentinel->getRoleRepository()->findBySlug('admin');

        /** @var UserRepositoryInterface $userRepository */
        $userRepository = $this->sentinel->getUserRepository();

        if (!$userRepository->hasRole($user, $adminRole)) {
            /** @var RoleRepositoryInterface $roleRepository */
            $roleRepository = $this->sentinel->getRoleRepository();

            $roleRepository->attachUser($adminRole->getId(), $user->getId());
        }
    }
}
