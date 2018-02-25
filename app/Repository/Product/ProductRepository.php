<?php
declare(strict_types = 1);

namespace App\Repository\Product;

use App\Entity\Category;
use App\Entity\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductRepository
{
    public function create(Product $product): void;

    public function deleteAll(): bool;

    public function find(int $id): ?Product;

    public function findForCategoryPaginated(Category $category, string $orderBy, bool $descending, int $perPage): LengthAwarePaginator;

    public function findPaginated(int $perPage): LengthAwarePaginator;

    public function findPaginatedWithOrder(string $orderBy, bool $descending, int $perPage): LengthAwarePaginator;

    public function findPaginateWithSearch(string $search, int $perPage): LengthAwarePaginator;

    public function findPaginatedWithOrderAndSearch(string $orderBy, bool $descending, string $search, int $perPage): LengthAwarePaginator;
}
