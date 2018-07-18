<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Servers;

use App\DataTransferObjects\Admin\Servers\DeleteResult;
use App\Exceptions\Server\ServerNotFoundException;
use App\Repository\Server\ServerRepository;
use App\Services\Server\Persistence\Persistence;

class DeleteHandler
{
    /**
     * @var ServerRepository
     */
    private $repository;

    /**
     * @var Persistence
     */
    private $persistence;

    public function __construct(ServerRepository $repository, Persistence $persistence)
    {
        $this->repository = $repository;
        $this->persistence = $persistence;
    }

    /**
     * @param int $serverId
     *
     * @return DeleteResult
     * @throws ServerNotFoundException
     */
    public function handle(int $serverId): DeleteResult
    {
        $server = $this->repository->find($serverId);
        if ($server === null) {
            throw ServerNotFoundException::byId($serverId);
        }
        $persistentServer = $this->persistence->retrieve();
        $destroyPersistence = $persistentServer !== null && $persistentServer->getId() === $server->getId();
        if ($destroyPersistence) {
            $this->persistence->destroy();
        }

        $this->repository->remove($server);

        return new DeleteResult($destroyPersistence);
    }
}
