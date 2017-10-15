<?php
declare(strict_types = 1);

namespace App\Services\User\Permissions;

use App\Models\User\UserInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Traits\ContainerTrait;

/**
 * Class Permissions
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Services\User
 */
class UserPermissions extends Permissions
{
    use ContainerTrait;

    /**
     * @var UserInterface
     */
    private $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
        $this->specifiedPermissions = $user->getPermissions();
        $this->roles = $this->user->getRoles();
    }

    public function addPermission(string $name, $value): void
    {
        $this->specifiedPermissions[$name] = $value;

        /** @var UserRepositoryInterface $repository */
        $repository = $this->make(UserRepositoryInterface::class);
        $repository->updatePermissions($this->user->getId(), $this->specifiedPermissions);
    }

    public function deletePermission(string $name): void
    {
        unset($this->specifiedPermissions[$name]);

        /** @var UserRepositoryInterface $repository */
        $repository = $this->make(UserRepositoryInterface::class);
        $repository->updatePermissions($this->user->getId(), $this->specifiedPermissions);
    }
}
