<?php
declare(strict_types=1);

namespace App\Services\Monitoring\Drivers;

use App\Entity\Server;
use App\Services\Monitoring\MonitoringException;
use D3lph1\MinecraftRconManager\Connector;
use D3lph1\MinecraftRconManager\Exceptions\ConnectSocketException;

/**
 * Class Rcon
 * Organizes the receipt of online statistics via the RCON protocol.
 */
class RconDriver implements Driver
{
    /**
     * @var Connector
     */
    private $connector;

    /**
     * @var string
     */
    private $command;

    /**
     * @var float
     */
    private $timeout;

    /**
     * @var RconResponseParser
     */
    private $parser;

    public function __construct(Connector $connector, string $command, float $timeout, RconResponseParser $parser)
    {
        $this->connector = $connector;
        $this->command = $command;
        $this->timeout = $timeout;
        $this->parser = $parser;
    }

    /**
     * {@inheritdoc}
     */
    public function retrieve(Server $server): DTO
    {
        try {
            $connection = $this->connector->connect($server->getIp(), $server->getPort(), $server->getPassword(), $this->timeout);

            return $this->parser->parse((string)$connection->send($this->command));
        } catch (ConnectSocketException $e) {
            throw new MonitoringException('Failed to connect to the server', 0, $e);
        }
    }
}
