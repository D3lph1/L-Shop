<?php
declare(strict_types = 1);

namespace App\Repository\Role;

use App\Entity\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface RoleRepository
{
    public function create(Role $role): void;

    public function update(Role $role): void;

    public function remove(Role $role): void;

    public function deleteAll(): bool;

    public function find(int $id): ?Role;

    public function findByName(string $name): ?Role;

    /**
     * @param int[] $identifiers
     *
     * @return Role[]
     */
    public function findWhereIdIn(array $identifiers): array;

    /**
     * @param string[] $names
     *
     * @return Role[]
     */
    public function findWhereNameIn(array $names): array;

    /**
     * @return Role[]
     */
    public function findByAll(): array;

    public function findPaginated(int $page, int $perPage): LengthAwarePaginator;

    public function findPaginatedWithOrder(string $orderBy, bool $descending, int $page, int $perPage): LengthAwarePaginator;

    public function findPaginateWithSearch(string $search,int $page, int $perPage): LengthAwarePaginator;

    public function findPaginatedWithOrderAndSearch(string $orderBy, bool $descending, string $search, int $page, int $perPage): LengthAwarePaginator;
}
