<?php
declare(strict_types = 1);

namespace App\DataTransferObjects;

/**
 * Class MonitoringPlayers
 * It serves to transfer information about players on the server between parts of the application.
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\DataTransferObjects
 */
final class MonitoringPlayers
{
    /**
     * @var int Server identifier.
     */
    private $serverId;

    /**
     * @var int Count of players at the moment.
     */
    private $now;

    /**
     * @var int Count of available slots.
     */
    private $total;

    /**
     * MonitoringPlayers constructor.
     *
     * @param int $serverId Server identifier
     * @param int $now Count of players at the moment.
     * @param int $total Count of available slots.
     */
    public function __construct(int $serverId, int $now, int $total)
    {
        $this->serverId = $serverId;
        $this->now = $now;
        $this->total = $total;
    }

    public function getServerId(): int
    {
        return $this->serverId;
    }

    public function getNow(): int
    {
        return $this->now;
    }

    public function getTotal(): int
    {
        return $this->total;
    }
}
