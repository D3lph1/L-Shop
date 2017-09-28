<?php
declare(strict_types = 1);

namespace App\Services\User\InitStrategies;

use App\Models\User\UserInterface;
use App\Models\Role\RoleInterface;
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
        /** @var RoleInterface $adminRole */
        $adminRole = $this->sentinel->getRoleRepository()->findBySlug('admin');

        /** @var RoleInterface $userRole */
        $userRole = $this->sentinel->getRoleRepository()->findBySlug('user');

        // TODO: refactor it!
        if (!$user->inRole($userRole)) {
            $adminRole->users()->detach($user);
            $userRole->users()->attach($user);
        }
    }
}