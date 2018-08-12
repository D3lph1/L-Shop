<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Servers\Edit;

use App\DataTransferObjects\Admin\Servers\Edit\RenderResult;
use App\DataTransferObjects\Admin\Servers\Edit\Server;
use App\Exceptions\Server\ServerNotFoundException;
use App\Repository\Server\ServerRepository;
use Illuminate\Contracts\Config\Repository;

class RenderHandler
{
    /**
     * @var ServerRepository
     */
    private $repository;

    /**
     * @var Repository
     */
    private $config;

    public function __construct(ServerRepository $repository, Repository $config)
    {
        $this->repository = $repository;
        $this->config = $config;
    }

    /**
     * @param int $serverId
     *
     * @return RenderResult
     * @throws ServerNotFoundException
     */
    public function handle(int $serverId): RenderResult
    {
        $server = $this->repository->find($serverId);
        if ($server === null) {
            throw ServerNotFoundException::byId($serverId);
        }

        return new RenderResult(new Server($server), $this->config->get('purchasing.distribution.distributors'));
    }
}
