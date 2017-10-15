<?php
declare(strict_types = 1);

namespace App\Repositories\Category;

use App\Models\Category\CategoryInterface;
use App\Repositories\BaseRepositoryInterface;

/**
 * Interface CategoryRepositoryInterface
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories\Category
 */
interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function create(CategoryInterface $entity): CategoryInterface;

    public function update(int $categoryId, CategoryInterface $entity): bool;

    public function allWithServers(array $categoryColumns, array $serverColumns): iterable;

    public function deleteByServerId(int $serverId): bool;

    public function countWithServer(int $serverId): int;

    public function delete(int $categoryId): bool;
}
