<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Servers\SwitchState;

use App\Exceptions\Server\ServerNotFoundException;
use App\Repository\Server\ServerRepository;

abstract class AbstractHandler
{
    /**
     * @var ServerRepository
     */
    private $repository;

    public function __construct(ServerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $serverId
     *
     * @throws ServerNotFoundException
     */
    public function handle(int $serverId): void
    {
        $server = $this->repository->find($serverId);
        if ($server === null) {
            throw ServerNotFoundException::byId($serverId);
        }

        $server->setEnabled($this->enabled());
        $this->repository->update($server);
    }

    abstract protected function enabled(): bool;
}
