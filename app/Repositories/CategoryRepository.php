<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository extends BaseRepository
{
    const MODEL = Category::class;

    public function deleteByServerId($serverId)
    {
        return Category::where('server_id', $serverId)->delete();
    }

    public function countWithServer($serverId)
    {
        return Category::where('server_id', $serverId)->count();
    }
}
