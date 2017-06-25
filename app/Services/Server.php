<?php

namespace App\Services;

use App\Exceptions\Server\AttemptToDeleteTheLastCategoryException;
use App\Exceptions\Server\AttemptToDeleteTheLastServerException;
use App\Repositories\CategoryRepository;
use App\Repositories\ServerRepository;
use Carbon\Carbon;

/**
 * Class Server
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services
 */
class Server
{
    /**
     * @var ServerRepository
     */
    private $serverRepository;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @param ServerRepository   $serverRepository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(ServerRepository $serverRepository, CategoryRepository $categoryRepository)
    {
        $this->serverRepository = $serverRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Enables the server
     *
     * @param int $serverId Server identifier.
     *
     * @return bool
     */
    public function enableServer($serverId)
    {
        return $this->serverRepository->enable($serverId);
    }

    /**
     * Disables the server.
     *
     * @param int $serverId Server identifier.
     *
     * @return bool
     */
    public function disableServer($serverId)
    {
        return $this->serverRepository->disable($serverId);
    }

    /**
     * Create a new server with attached categories
     *
     * @param string $name              Server name.
     * @param bool   $enabled           Enable the server after creation.
     * @param array  $categories        Attached server categories.
     * @param string $ip                Server ip address.
     * @param int    $port              Server RCON port.
     * @param string $password          Server RCON password.
     * @param bool   $monitoringEnabled Enable the server monitoring after creation.
     */
    public function createServer($name, $enabled, array $categories, $ip, $port, $password, $monitoringEnabled)
    {
        \DB::transaction(function () use ($name, $enabled, $categories, $ip, $port, $password, $monitoringEnabled) {
            $server = $this->serverRepository->create([
                'name' => $name,
                'enabled' => $enabled,
                'ip' => $ip,
                'port' => $port,
                'password' => $password,
                'monitoring_enabled' => $monitoringEnabled
            ]);

            foreach ($categories as $category) {
                $query = [
                    'name' => $category,
                    'server_id' => $server->id,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => null
                ];

                $this->categoryRepository->create($query);
            }
        });
    }

    /**
     * Update given server with categories.
     *
     * @param int    $serverId          Updated server identifier.
     * @param string $name              Updated server name.
     * @param bool   $enabled           Enable this server after the update.
     * @param array  $categories        New categories attached to this server.
     * @param string $ip                Updated server ip address.
     * @param int    $port              Updated server RCON port.
     * @param string $password          Updated server RCON password.
     * @param bool   $monitoringEnabled Enable monitoring for this server after the update.
     */
    public function updateServer($serverId, $name, $enabled, array $categories, $ip, $port, $password, $monitoringEnabled)
    {
        \DB::transaction(function () use ($serverId, $name, $enabled, $categories, $ip, $port, $password, $monitoringEnabled) {
            $this->serverRepository->update($serverId, [
                'name' => $name,
                'enabled' => $enabled,
                'ip' => $ip,
                'port' => $port,
                'password' => $password,
                'monitoring_enabled' => $monitoringEnabled
            ]);

            foreach ($categories as $key => $value) {
                $this->categoryRepository->update((int)$key, [
                    'name' => $value[0]
                ]);
            }
        });
    }

    /**
     * Remove given server with attached categories.
     *
     * @param int $serverId Removing server identifier.
     *
     * @throws AttemptToDeleteTheLastServerException
     */
    public function removeServer($serverId)
    {
        $count = $this->serverRepository->count();

        if ($count === 1) {
            throw  new AttemptToDeleteTheLastServerException();
        }

        \DB::transaction(function () use ($serverId) {
            $this->serverRepository->delete($serverId);
            $this->categoryRepository->deleteByServerId($serverId);
        });
    }

    /**
     * Create a new category for the given server.
     *
     * @param int    $serverId The server identifier to which the category will be bound.
     * @param string $name New category name.
     */
    public function createCategory($serverId, $name)
    {
        \DB::transaction(function () use ($serverId, $name) {
            $this->categoryRepository->create([
                'name' => $name,
                'server_id' => $serverId
            ]);
        });
    }

    /**
     * Attempt to remove given category.
     *
     * @param int $serverId The identifier of the server to which the category is bound.
     * @param int $categoryId Removing category identifier.
     */
    public function removeCategory($serverId, $categoryId)
    {
        if ($this->categoryRepository->countWithServer($serverId) === 1) {
            throw new AttemptToDeleteTheLastCategoryException();
        }

        $this->categoryRepository->delete($categoryId);
    }
}
