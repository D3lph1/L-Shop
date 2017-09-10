<?php

namespace App\Repositories;

use App\Models\Item;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ItemRepository
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories
 */
class ItemRepository extends BaseRepository
{
    const MODEL = 'App\Models\Item';

    public function create(array $attributes): Model
    {
        return Item::create($attributes);
    }

    public function forAdmin(
        array $columns = [],
        ?string $orderBy = null,
        ?string $orderType = 'ASC',
        ?string $filter = null
    ): LengthAwarePaginator
    {
        $columns = $this->prepareColumns($columns);
        $builder = Item::select($columns);

        if (!is_null($orderBy)) {
            $builder->orderBy($orderBy, $orderType);
        }

        if (!is_null($filter)) {
            $builder->where('name', 'like', $filter . '%');
        }

        return $builder->paginate(50);
    }
}
