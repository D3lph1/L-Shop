<?php
declare(strict_types = 1);

namespace App\TransactionScripts;

use App\Models\Server\ServerInterface;
use App\Services\Monitoring\MonitoringInterface;

class Monitoring
{
    /**
     * @var MonitoringInterface
     */
    private $monitoring;

    public function __construct(MonitoringInterface $monitoring)
    {
        $this->monitoring = $monitoring;
    }

    public function forServers(iterable $servers): array
    {
        if (s_get('monitoring.enabled')) {
            $monitoring = [];

            /** @var ServerInterface $server */
            foreach ($servers as $server) {
                if ($server->isMonitoringEnabled()) {
                    $monitoring[] = $this->monitoring->getPlayers($server->getId());
                }
            }

            return $monitoring;
        }

        return [];
    }
}
