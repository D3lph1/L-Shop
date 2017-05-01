<?php

namespace App\Services;

use App\Exceptions\Server\AttemptToDeleteTheLastCategoryException;
use App\Exceptions\Server\AttemptToDeleteTheLastServerException;
use App\Repositories\CategoryRepository;
use App\Repositories\ServerRepository;
use Carbon\Carbon;

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
     * @param int $serverId
     *
     * @return bool
     */
    public function enabledServer($serverId)
    {
        return $this->serverRepository->enable($serverId);
    }

    /**
     * Disables the server
     *
     * @param int $serverId
     *
     * @return bool
     */
    public function disabledServer($serverId)
    {
        return $this->serverRepository->disable($serverId);
    }

    /**
     * Create a new server with attached categories
     *
     * @param string $name
     * @param bool   $enabled
     * @param array  $categories
     */
    public function createServer($name, $enabled, array $categories)
    {
        \DB::transaction(function () use ($name, $enabled, $categories) {
            $server = $this->serverRepository->create([
                'name' => $name,
                'enabled' => $enabled
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
     * Update given server with categories
     *
     * @param int    $serverId
     * @param string $name
     * @param bool   $enabled
     * @param array  $categories
     */
    public function updateServer($serverId, $name, $enabled, array $categories)
    {
        \DB::transaction(function () use ($serverId, $name, $enabled, $categories) {
            $this->serverRepository->update($serverId, [
                'name' => $name,
                'enabled' => $enabled
            ]);

            foreach ($categories as $key => $value) {
                $this->categoryRepository->update((int)$key, [
                    'name' => $value[0]
                ]);
            }
        });
    }

    /**
     * Remove given server with attached categories
     *
     * @param int $serverId
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
     * Create a new category for the given server
     *
     * @param int $serverId
     * @param string $name
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
     * Attempt to remove given category
     *
     * @param int $serverId
     * @param int $categoryId
     */
    public function removeCategory($serverId, $categoryId)
    {
        if ($this->categoryRepository->countWithServer($serverId) === 1) {
            throw new AttemptToDeleteTheLastCategoryException();
        }

        $this->categoryRepository->delete($categoryId);
    }
}
