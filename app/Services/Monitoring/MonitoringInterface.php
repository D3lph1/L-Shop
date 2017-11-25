<?php
declare(strict_types = 1);

namespace App\Services\Monitoring;

use App\DataTransferObjects\MonitoringPlayers;

/**
 * Interface MonitoringInterface
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Services\Monitoring
 */
interface MonitoringInterface
{
    /**
     * Get monitoring-information about the server.
     */
    public function getPlayers(int $serverId): ?MonitoringPlayers;
}
