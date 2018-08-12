<?php
declare(strict_types=1);

namespace App\Services\Server\Persistence;

use App\Entity\Server;
use App\Repository\Server\ServerRepository;
use App\Services\Server\Persistence\Storage\Storage;

class Persistence
{
    /**
     * @var Storage
     */
    private $storage;

    /**
     * @var ServerRepository
     */
    private $repository;

    public function __construct(Storage $storage, ServerRepository $repository)
    {
        $this->storage = $storage;
        $this->repository = $repository;
    }

    public function persist(Server $server): void
    {
        $this->storage->persist($server->getId());
    }

    public function retrieve(): ?Server
    {
        $serverId = $this->storage->retrieve();
        if ($serverId === null) {
            return null;
        }

        $server = $this->repository->find($serverId);

        return $server;
    }

    public function destroy(): void
    {
        $this->storage->remove();
    }
}
