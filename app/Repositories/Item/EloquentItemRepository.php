<?php
declare(strict_types = 1);

namespace App\Repositories\Item;

use App\DataTransferObjects\Item;
use App\Models\Item\EloquentItem;
use App\Models\Item\ItemInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentItemRepository implements ItemRepositoryInterface
{
    public function create(Item $dto): ItemInterface
    {
        return EloquentItem::create([
            'name' => $dto->getName(),
            'description' => $dto->getDescription(),
            'type' => $dto->getType(),
            'item' => $dto->getItem(),
            'image' => $dto->getImage(), // TODO: Image name
            'extra' => $dto->getExtra()
        ]);
    }

    public function exists(int $id): bool
    {
        return EloquentItem::where('id', $id)->exists();
    }

    public function all(array $columns): iterable
    {
        return EloquentItem::all($columns);
    }

    public function forAdmin($columns, ?string $orderBy = null, ?string $orderType = 'ASC', ?string $filter = null): LengthAwarePaginator
    {
        {
            $builder = EloquentItem::select($columns);

            if (!is_null($orderBy)) {
                $builder->orderBy($orderBy, $orderType);
            }

            if (!is_null($filter)) {
                $builder->where('name', 'like', $filter . '%');
            }

            return $builder->paginate(50);
        }
    }
}
