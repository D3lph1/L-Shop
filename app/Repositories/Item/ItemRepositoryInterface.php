<?php
declare(strict_types = 1);

namespace App\Repositories\Item;

use App\DataTransferObjects\Item;
use App\Models\Item\ItemInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ItemRepositoryInterface
{
    public function create(Item $dto): ItemInterface;

    public function exists(int $id): bool;

    public function all(array $columns): iterable;

    public function forAdmin($columns, ?string $orderBy = null, ?string $orderType = 'ASC', ?string $filter = null): LengthAwarePaginator;
}
