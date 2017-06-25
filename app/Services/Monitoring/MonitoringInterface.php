<?php

namespace App\Services\Monitoring;

use App\DataTransferObjects\MonitoringPlayers;

/**
 * Interface MonitoringInterface
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services\Monitoring
 */
interface MonitoringInterface
{
    /**
     * Get monitoring-information about the server.
     *
     * @param int $serverId Server identifier.
     *
     * @return MonitoringPlayers
     */
    public function getPlayers($serverId);
}
