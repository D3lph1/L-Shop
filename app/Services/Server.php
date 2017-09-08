<?php

namespace App\Services;

use App\DataTransferObjects\Admin\Category;
use App\DataTransferObjects\Admin\Server as DTO;
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
     * Enables the server.
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
     * Create a new server with attached categories.
     *
     * @param DTO $dto
     */
    public function createServer(DTO $dto)
    {
        \DB::transaction(function () use ($dto) {
            $server = $this->serverRepository->create([
                'name' => $dto->getName(),
                'enabled' => $dto->isEnabled(),
                'ip' => $dto->getIp(),
                'port' => $dto->getPort(),
                'password' => $dto->getPassword(),
                'monitoring_enabled' => $dto->isMonitoringEnabled()
            ]);

            foreach ($dto->getCategories() as $category) {
                $query = [
                    'name' => $category->getName(),
                    'server_id' => $server->id
                ];

                $this->categoryRepository->create($query);
            }
        });
    }

    /**
     * Update given server with categories.
     *
     * @param DTO $dto
     */
    public function updateServer(DTO $dto)
    {
        \DB::transaction(function () use ($dto) {
            $this->serverRepository->update($dto->getId(), [
                'name' => $dto->getName(),
                'enabled' => $dto->isEnabled(),
                'ip' => $dto->getIp(),
                'port' => $dto->getPort(),
                'password' => $dto->getPassword(),
                'monitoring_enabled' => $dto->isMonitoringEnabled()
            ]);

            foreach ($dto->getCategories() as $category) {
                $this->categoryRepository->update($category->getId(), [
                    'name' => $category->getName()
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
     * @param Category $dto
     */
    public function createCategory(Category $dto)
    {
        \DB::transaction(function () use ($dto) {
            $this->categoryRepository->create([
                'name' => $dto->getName(),
                'server_id' => $dto->getServerId()
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
