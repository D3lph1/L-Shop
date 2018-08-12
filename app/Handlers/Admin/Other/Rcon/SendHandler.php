<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Other\Rcon;

use App\Exceptions\Server\ServerNotFoundException;
use App\Repository\Server\ServerRepository;
use D3lph1\MinecraftRconManager\Connector;

class SendHandler
{
    private const CONNECTION_TIMEOUT = 3;

    /**
     * @var ServerRepository
     */
    private $serverRepository;

    /**
     * @var Connector
     */
    private $connector;

    public function __construct(ServerRepository $serverRepository, Connector $connector)
    {
        $this->serverRepository = $serverRepository;
        $this->connector = $connector;
    }

    public function handle(int $serverId, string $command): string
    {
        $server = $this->serverRepository->find($serverId);
        if ($server === null) {
            throw ServerNotFoundException::byId($serverId);
        }

        $connection = $this->connector->connect($server->getIp(), $server->getPort(), $server->getPassword(), self::CONNECTION_TIMEOUT);

        return $connection->send($command);
    }
}
