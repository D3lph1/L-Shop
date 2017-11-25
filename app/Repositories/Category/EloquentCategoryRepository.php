<?php
declare(strict_types = 1);

namespace App\Repositories\Category;

use App\DataTransferObjects\Category;
use App\Models\Category\CategoryInterface;
use App\Models\Category\EloquentCategory;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Traits\ContainerTrait;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class EloquentCategoryRepository
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories\Category
 */
class EloquentCategoryRepository implements CategoryRepositoryInterface
{
    use ContainerTrait;

    public function create(CategoryInterface $entity): CategoryInterface
    {
        return EloquentCategory::create([
            'id' => $entity->getId(),
            'name' => $entity->getName(),
            'server_id' => $entity->getServerId()
        ]);
    }

    public function update(int $categoryId, CategoryInterface $entity): bool
    {
        return (bool)EloquentCategory::where('id', $categoryId)->update([
            'name' => $entity->getName(),
            'server_id' => $entity->getServerId()
        ]);
    }

    public function allWithServers(array $categoryColumns, array $serverColumns): iterable
    {
        return EloquentCategory::select(array_merge($categoryColumns, ['server_id']))
            ->with([
                'server' => function ($query) use ($serverColumns) {
                    /** @var Builder $query */
                    $query->select(array_merge($serverColumns, ['id']));
                }
            ])
            ->get();
    }

    public function deleteByServerId(int $serverId): bool
    {
        /** @var ProductRepositoryInterface $productRepository */
        $productRepository = $this->make(ProductRepositoryInterface::class);
        $productRepository->deleteByServer($serverId);

        return (bool)EloquentCategory::where('server_id', $serverId)->delete();
    }

    public function countWithServer(int $serverId): int
    {
        return EloquentCategory::where('server_id', $serverId)->count();
    }

    public function delete(int $categoryId): bool
    {
        /** @var ProductRepositoryInterface $productRepository */
        $productRepository = $this->make(ProductRepositoryInterface::class);
        $productRepository->deleteByCategory($categoryId);

        return (bool)EloquentCategory::where('id', $categoryId)->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function truncate(): void
    {
        EloquentCategory::truncate();
    }
}
