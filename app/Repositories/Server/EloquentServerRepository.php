<?php
declare(strict_types = 1);

namespace App\Repositories\Server;

use App\DataTransferObjects\Server;
use App\Models\Category\EloquentCategory;
use App\Models\Server\EloquentServer;
use App\Models\Server\ServerInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class EloquentServerRepository
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories\Server
 */
class EloquentServerRepository implements ServerRepositoryInterface
{
    public function create(Server $dto): ServerInterface
    {
        return EloquentServer::create([
            'name' => $dto->getName(),
            'enabled' => $dto->isEnabled(),
            'ip' => $dto->getIp(),
            'port' => $dto->getPort(),
            'password' => $dto->getPassword(),
            'monitoring_enabled' => $dto->isMonitoringEnabled()
        ]);
    }

    public function update(int $serverId, Server $dto): bool
    {
        return EloquentServer::where('id', $serverId)->update([
            'name' => $dto->getName(),
            'enabled' => $dto->isEnabled(),
            'ip' => $dto->getIp(),
            'port' => $dto->getPort(),
            'password' => $dto->getPassword(),
            'monitoring_enabled' => $dto->isMonitoringEnabled()
        ]);
    }

    public function find(int $id, array $columns)
    {
        return EloquentServer::find($id, $columns);
    }

    public function all(array $columns): iterable
    {
        return EloquentServer::all($columns);
    }

    public function getWithCategories(array $columns): iterable
    {
        $servers = EloquentServer::select($columns)->get();
        $categories = EloquentCategory::select()->get();
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

    public function allWithCategories(array $serverColumns, array $categoryColumns): iterable
    {
        return EloquentServer::select(array_merge($serverColumns, ['servers.id']))
            ->with([
                'categories' => function ($query) use ($categoryColumns) {
                    /** @var Builder $query */
                    $query->select(array_merge($categoryColumns, ['categories.server_id']));
                }
            ])
            ->get();
    }

    public function categories(int $serverId, array $columns): iterable
    {
        if (is_array($serverId)) {
            $builder = EloquentCategory::select($columns)->whereIn('server_id', $serverId);
        } else {
            $builder = EloquentCategory::select($columns)->where('server_id', $serverId);
        }

        return $builder->get();
    }

    public function enable(int $serverId): bool
    {
        return $this->changeEnabledServerMode($serverId, true);
    }

    public function disable(int $serverId): bool
    {
        return $this->changeEnabledServerMode($serverId, false);
    }

    public function count(): int
    {
        return EloquentServer::count('id');
    }

    private function changeEnabledServerMode(int $id, bool $mode): bool
    {
        return EloquentServer::where('id', $id)->update(['enabled' => $mode]);
    }

    public function delete(int $serverId): void
    {
        EloquentServer::where('id', $serverId)->delete();
    }
}
