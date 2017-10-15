<?php
declare(strict_types = 1);

namespace App\TransactionScripts;

use App\Models\Server\ServerInterface;
use App\Repositories\Server\ServerRepositoryInterface;
use App\Services\Monitoring\MonitoringInterface;
use App\Traits\ContainerTrait;
use D3lph1\MinecraftRconManager\Connector;

/**
 * Class Monitoring
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\TransactionScripts
 */
class Monitoring
{
    use ContainerTrait;

    /**
     * @var ServerRepositoryInterface
     */
    private $serverRepository;

    public function init(?iterable $servers): Connector
    {
        if (!$servers) {
            /** @var ServerInterface[] $servers */
            $servers = $this->make(ServerRepositoryInterface::class)->all(
                ['id', 'name', 'enabled', 'ip', 'port', 'password', 'monitoring_enabled', 'created_at', 'updated_at']
            );
        }

        $rcon = new Connector();

        foreach ($servers as $server) {
            $rcon->add($server->getId(), $server->getIp(), $server->getPort(), $server->getPassword(), s_get('monitoring.rcon.timeout', 1));
        }

        return $rcon;
    }

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
