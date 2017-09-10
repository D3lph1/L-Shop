<?php
declare(strict_types = 1);

namespace App\Repositories;

use App\Models\Category;

/**
 * Class CategoryRepository
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories
 */
class CategoryRepository extends BaseRepository
{
    const MODEL = Category::class;

    public function deleteByServerId(int $serverId): bool
    {
        return Category::where('server_id', $serverId)->delete();
    }

    public function countWithServer(int $serverId): int
    {
        return Category::where('server_id', $serverId)->count();
    }
}
