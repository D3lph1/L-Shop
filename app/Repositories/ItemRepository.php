<?php

namespace App\Repositories;

use App\Models\Item;

/**
 * Class ItemRepository
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Repositories
 */
class ItemRepository extends BaseRepository
{
    const MODEL = 'App\Models\Item';

    public function create(array $attributes)
    {
        return Item::create($attributes);
    }
}
