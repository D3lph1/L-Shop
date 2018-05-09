<?php
declare(strict_types = 1);

namespace App\Services\Purchasing\Distributors\RconDistribution;

use App\Entity\Server;
use D3lph1\MinecraftRconManager\Connector;
use D3lph1\MinecraftRconManager\Rcon;

/**
 * Class Connections
 * Responsible for storing and creating connections to Rcon with Rcon distributing items.
 */
class Connections
{
    /**
     * @var Connector
     */
    private $connector;

    /**
     * @var float
     */
    private $timeout;

    /**
     * Connections constructor.
     *
     * @param Connector $connector
     * @param float     $timeout
     */
    public function __construct(Connector $connector, float $timeout)
    {
        $this->connector = $connector;
        $this->timeout = $timeout;
    }

    /**
     * It establish the Rcon connection to the server only if it was not established early.
     *
     * @param Server $server
     *
     * @return Rcon
     */
    public function connect(Server $server): Rcon
    {
        if ($this->connector->exists($server->getId())) {
            return $this->connector->get($server->getId());
        }

        $this->connector->add(
            $server->getId(),
            $server->getIp(),
            $server->getPort(),
            $server->getPassword(),
            $this->timeout
        );

        return $this->connector->get($server->getId());
    }
}
