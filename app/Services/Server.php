<?php
declare(strict_types = 1);

namespace App\Services;

use App\DataTransferObjects\Category;
use App\DataTransferObjects\Server as DTO;
use App\Exceptions\Server\AttemptToDeleteTheLastCategoryException;
use App\Exceptions\Server\AttemptToDeleteTheLastServerException;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Server\ServerRepositoryInterface;

/**
 * Class Server
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Services
 */
class Server
{
    /**
     * @var ServerRepositoryInterface
     */
    private $serverRepository;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @param ServerRepositoryInterface   $serverRepository
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(ServerRepositoryInterface $serverRepository, CategoryRepositoryInterface $categoryRepository)
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
            $server = $this->serverRepository->create($dto);

            foreach ($dto->getCategories() as $category) {
                $this->categoryRepository->create(
                    (new Category())
                        ->setName($category->getName())
                        ->setServerId($server->getId())
                );
            }
        });
    }

    /**
     * Update given server with categories.
     */
    public function updateServer(DTO $dto)
    {
        \DB::transaction(function () use ($dto) {
            $this->serverRepository->update($dto->getId(), $dto);

            foreach ($dto->getCategories() as $category) {
                $this->categoryRepository->update($category->getId(), $category);
            }
        });
    }

    /**
     * Remove given server with attached categories.
     *
     * @throws AttemptToDeleteTheLastServerException
     */
    public function removeServer(int $serverId): void
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
            $this->categoryRepository->create($dto);
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
