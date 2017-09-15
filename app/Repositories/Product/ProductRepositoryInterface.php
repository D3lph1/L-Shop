<?php
declare(strict_types = 1);

namespace App\Repositories\Product;

use App\DataTransferObjects\Product;
use App\Models\Product\ProductInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function create(Product $dto): ProductInterface;

    public function update(int $productId, Product $dto): bool;

    public function exists(int $id): bool;

    public function withItems(int $id, array $productColumns, array $itemColumns): ProductInterface;

    public function withItemsMultiple(array $id, array $productColumns, array $itemColumns): iterable;

    public function forCatalog(int $serverId, int $category, array $productColumns, array $itemColumns): LengthAwarePaginator;

    public function withCategoryWithServerPaginated(
        array $productColumns,
        array $temColumns,
        array $categoryColumns,
        array $serverColumns,
        string $orderBy,
        string $orderType,
        ?string $filter = null
    ): LengthAwarePaginator;

    public function delete(int $productId): bool;

    public function deleteByItemId(int $itemId): bool;
}
