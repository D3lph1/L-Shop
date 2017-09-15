<?php
declare(strict_types = 1);

namespace App\Repositories\Category;

use App\DataTransferObjects\Category;
use App\Models\Category\CategoryInterface;
use App\Models\Category\EloquentCategory;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class EloquentCategoryRepository
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories\Category
 */
class EloquentCategoryRepository implements CategoryRepositoryInterface
{
    public function create(Category $category): CategoryInterface
    {
        return EloquentCategory::create([
            'name' => $category->getName(),
            'server_id' => $category->getServerId()
        ]);
    }

    public function update(int $categoryId, Category $dto): bool
    {
        return EloquentCategory::where('id', $categoryId)->update([
            'name' => $dto->getName(),
            'server_id' => $dto->getServerId()
        ]);
    }

    public function allWithServers(array $categoryColumns, array $serverColumns): iterable
    {
        return EloquentCategory::select(array_merge($categoryColumns, ['server_id']))
            ->with([
                'server' => function ($query) use($serverColumns) {
                    /** @var Builder $query */
                    $query->select(array_merge($serverColumns, ['id']));
                }
            ])
            ->get();
    }

    public function deleteByServerId(int $serverId): bool
    {
        return EloquentCategory::where('server_id', $serverId)->delete();
    }

    public function countWithServer(int $serverId): int
    {
        return EloquentCategory::where('server_id', $serverId)->count();
    }

    public function delete(int $categoryId): void
    {
        EloquentCategory::where('id', $categoryId)->delete();
    }
}
