<?php
declare(strict_types = 1);

namespace App\Repositories\Category;

use App\DataTransferObjects\Category;
use App\Models\Category\CategoryInterface;

/**
 * Interface CategoryRepositoryInterface
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories\Category
 */
interface CategoryRepositoryInterface
{
    public function create(Category $category): CategoryInterface;

    public function update(int $categoryId, Category $dto): bool;

    public function allWithServers(array $categoryColumns, array $serverColumns): iterable;

    public function deleteByServerId(int $serverId): bool;

    public function countWithServer(int $serverId): int;

    public function delete(int $categoryId): bool;
}
