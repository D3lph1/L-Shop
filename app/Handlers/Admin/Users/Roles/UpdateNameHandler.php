<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Users\Roles;

use App\Exceptions\Role\RoleAlreadyExistsException;
use App\Exceptions\Role\RoleNotFoundException;
use App\Repository\Role\RoleRepository;

class UpdateNameHandler
{
    /**
     * @var RoleRepository
     */
    private $repository;

    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int    $roleId
     * @param string $newName
     *
     * @throws RoleAlreadyExistsException
     */
    public function handle(int $roleId, string $newName): void
    {
        $role = $this->repository->find($roleId);

        if ($role === null) {
            throw RoleNotFoundException::byId($roleId);
        }

        $roleWithSameName = $this->repository->findByName($newName);
        if ($roleWithSameName !== null && $roleWithSameName->getId() !== $role->getId()) {
            throw RoleAlreadyExistsException::withName($newName);
        }

        $this->repository->update($role->setName($newName));
    }
}
