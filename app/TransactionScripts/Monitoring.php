<?php
declare(strict_types = 1);

namespace App\TransactionScripts;

use App\Models\Server\ServerInterface;
use App\Services\Monitoring\MonitoringInterface;
use App\Traits\ContainerTrait;

/**
 * Class Monitoring
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\TransactionScripts
 */
class Monitoring
{
    use ContainerTrait;

    public function forServers(iterable $servers): array
    {
        if (s_get('monitoring.enabled')) {
            /** @var MonitoringInterface $monitoringInterface */
            $monitoringInterface = $this->make(MonitoringInterface::class);
            $monitoring = [];

            /** @var ServerInterface $server */
            foreach ($servers as $server) {
                if ($server->isMonitoringEnabled()) {
                    $monitoring[] = $monitoringInterface->getPlayers($server->getId());
                }
            }

            return $monitoring;
        }

        return [];
    }
}
