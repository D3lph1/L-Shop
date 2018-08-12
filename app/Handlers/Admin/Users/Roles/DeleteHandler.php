<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Users\Roles;

use App\Exceptions\Role\RoleNotFoundException;
use App\Repository\Role\RoleRepository;

class DeleteHandler
{
    /**
     * @var RoleRepository
     */
    private $repository;

    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(int $roleId): void
    {
        $role = $this->repository->find($roleId);

        if ($role === null) {
            throw RoleNotFoundException::byId($roleId);
        }

        $this->repository->remove($role);
    }
}
