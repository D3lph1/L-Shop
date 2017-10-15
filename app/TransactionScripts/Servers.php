<?php
declare(strict_types = 1);

namespace App\TransactionScripts;

use App\DataTransferObjects\Admin\EditedServer;
use App\DataTransferObjects\Server;
use App\Exceptions\Server\AttemptToDeleteTheLastCategoryException;
use App\Exceptions\Server\AttemptToDeleteTheLastServerException;
use App\Exceptions\Server\NotFoundException;
use App\Models\Category\CategoryInterface;
use App\Models\Server\ServerInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Server\ServerRepositoryInterface;
use App\Traits\ContainerTrait;
use Illuminate\Support\Facades\DB;

/**
 * Class Servers
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\TransactionScripts
 */
class Servers
{
    use ContainerTrait;

    /**
     * @var ServerRepositoryInterface
     */
    private $serverRepository;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    public function __construct(ServerRepositoryInterface $serverRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->serverRepository = $serverRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function createServer(Server $dto)
    {
        DB::transaction(function () use ($dto) {
            /** @var ServerInterface $entity */
            $entity = $this->make(ServerInterface::class);
            $entity
                ->setName($dto->getName())
                ->setEnabled($dto->isEnabled())
                ->setIp($dto->getIp())
                ->setPort($dto->getPort())
                ->setPassword($dto->getPassword())
                ->setMonitoringEnabled($dto->isMonitoringEnabled());

            $server = $this->serverRepository->create($entity);

            foreach ($dto->getCategories() as $category) {
                /** @var CategoryInterface $entity */
                $entity = $this->make(CategoryInterface::class);
                $entity
                    ->setName($category->getName())
                    ->setServerId($server->getId());
                $this->categoryRepository->create($entity);
            }
        });
    }

    public function updateServer(Server $dto)
    {
        DB::transaction(function () use ($dto) {
            /** @var ServerInterface $entity */
            $entity = $this->make(ServerInterface::class);
            $entity
                ->setName($dto->getName())
                ->setEnabled($dto->isEnabled())
                ->setIp($dto->getIp())
                ->setPort($dto->getPort())
                ->setPassword($dto->getPassword())
                ->setMonitoringEnabled($dto->isMonitoringEnabled());

            $this->serverRepository->update($dto->getId(), $entity);

            foreach ($dto->getCategories() as $category) {
                /** @var CategoryInterface $entity */
                $entity = $this->make(CategoryInterface::class);
                $entity
                    ->setName($category->getName())
                    ->setServerId($category->getServerId());

                $this->categoryRepository->update($category->getId(), $entity);
            }
        });
    }

    public function removeServer(int $serverId)
    {
        $count = $this->serverRepository->count();

        if ($count === 1) {
            throw  new AttemptToDeleteTheLastServerException();
        }

        DB::transaction(function () use ($serverId) {
            $this->serverRepository->delete($serverId);
            $this->categoryRepository->deleteByServerId($serverId);
        });
    }

    public function createCategory(CategoryInterface $entity): bool
    {
        return (bool)$this->categoryRepository->create($entity);
    }

    public function removeCategory(int $categoryId, int $serverId): bool
    {
        if ($this->categoryRepository->countWithServer($serverId) === 1) {
            throw new AttemptToDeleteTheLastCategoryException();
        }

        return $this->categoryRepository->delete($categoryId);
    }

    public function informationForEdit(int $serverId, iterable $servers): EditedServer
    {
        $server = null;

        /** @var ServerInterface $one */
        foreach ($servers as $one) {
            if ($one->getId() === $serverId) {
                $server = $one;
                break;
            }
        }

        if (is_null($server)) {
            throw new NotFoundException($serverId);
        }

        $categories = $this->serverRepository->categories($server->getId(), ['id', 'name']);

        return (new EditedServer())
            ->setServer($server)
            ->setCategories($categories);
    }

    public function informationForList(): iterable
    {
        return $this->serverRepository->getWithCategories([
            'servers.id',
            'servers.name',
            'servers.enabled'
        ]);
    }

    /**
     * Enables the server.
     *
     * @param int $serverId Server identifier.
     *
     * @return bool
     */
    public function enableServer(int $serverId): bool
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
    public function disableServer(int $serverId): bool
    {
        return $this->serverRepository->disable($serverId);
    }
}
