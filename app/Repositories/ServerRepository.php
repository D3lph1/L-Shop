<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Server;

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

    /**
     * @param array $columns
     *
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getWithCategories($columns = [])
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

    /**
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function allWithCategories($columns = [])
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
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function categories($serverId, $columns = [])
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
     * Enables the server
     *
     * @param int $serverId
     *
     * @return bool
     */
    public function enable($serverId)
    {
        return $this->changeEnabledServerMode($serverId, true);
    }

    /**
     * Disables the server
     *
     * @param int $serverId
     *
     * @return bool
     */
    public function disable($serverId)
    {
        return $this->changeEnabledServerMode($serverId, false);
    }

    /**
     * @return int
     */
    public function count()
    {
        return Server::count('id');
    }

    /**
     * @param int  $id
     * @param bool $mode
     *
     * @return bool
     */
    private function changeEnabledServerMode($id, $mode)
    {
        return Server::where('id', $id)->update(['enabled' => $mode]);
    }
}
