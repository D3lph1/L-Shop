<?php

namespace App\DataTransferObjects;

/**
 * Class MonitoringPlayers
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\DataTransferObjects
 */
class MonitoringPlayers
{
    /**
     * @var int
     */
    private $serverId;

    /**
     * @var int
     */
    private $now;

    /**
     * @var int
     */
    private $total;

    /**
     * MonitoringPlayers constructor.
     *
     * @param     $serverId
     * @param int $now
     * @param int $total
     */
    public function __construct($serverId, $now, $total)
    {
        $this->serverId = $serverId;
        $this->now = $now;
        $this->total = $total;
    }

    /**
     * @return int
     */
    public function getServerId()
    {
        return $this->serverId;
    }

    /**
     * @return int
     */
    public function getNow()
    {
        return $this->now;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }
}
