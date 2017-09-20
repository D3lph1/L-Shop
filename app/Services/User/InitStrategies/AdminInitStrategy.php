<?php
declare(strict_types = 1);

namespace App\Services\User\InitStrategies;

use App\Models\User\UserInterface;
use App\Repositories\Role\RoleInterface;
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

        // TODO: refactor it!
        if (!$user->inRole($adminRole)) {
            $userRole->users()->detach($user);
            $adminRole->users()->attach($user);
        }
    }
}
