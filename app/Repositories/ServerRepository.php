<?php
declare(strict_types = 1);

namespace App\Repositories;

use App\Models\Category;
use App\Models\Server;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ServerRepository
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Repositories
 */
class ServerRepository extends BaseRepository
{
    const MODEL = Server::class;

    public function getWithCategories(array $columns = []): array
    {
        $columns = $this->prepareColumns($columns);

        $servers = Server::select($columns)->get();
        $categories = Category::select()->get();
        $servers = $servers->toArray();

        foreach ($servers as &$server) {
            foreach ($categories as $category) {
                if ($category->server_id == $server['id']) {
                    $server['categories'][] = $category->name;
                }
            }
            $server = (object)$server;
        }

        return $servers;
    }

    public function allWithCategories(array $columns = []): Collection
    {
        $columns = $this->prepareColumns($columns);

        return Server::select($columns)
            ->join('categories', 'categories.server_id', 'servers.id')
            ->get();
    }

    /**
     * @param int|array $serverId
     * @param array     $columns
     *
     * @return Collection
     */
    public function categories($serverId, array $columns = []): Collection
    {
        $columns = $this->prepareColumns($columns);

        if (is_array($serverId)) {
            $builder = Category::select($columns)->whereIn('server_id', $serverId);
        } else {
            $builder = Category::select($columns)->where('server_id', $serverId);
        }

        return $builder->get();
    }

    /**
     * Enables the server.
     */
    public function enable(int $serverId): bool
    {
        return $this->changeEnabledServerMode($serverId, true);
    }

    /**
     * Disables the server.
     */
    public function disable(int $serverId): bool
    {
        return $this->changeEnabledServerMode($serverId, false);
    }

    public function count(): int
    {
        return Server::count('id');
    }

    private function changeEnabledServerMode(int $id, bool $mode): bool
    {
        return Server::where('id', $id)->update(['enabled' => $mode]);
    }
}
