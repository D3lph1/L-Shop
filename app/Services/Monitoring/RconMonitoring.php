<?php

namespace App\Services\Monitoring;

use App\DataTransferObjects\MonitoringPlayers;
use D3lph1\MinecraftRconManager\Connector;

/**
 * Class RconMonitoring
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services\Monitoring
 */
class RconMonitoring implements MonitoringInterface
{
    /**
     * @var Connector
     */
    protected $connector;

    /**
     * RconMonitoring constructor.
     *
     * @param Connector $connector
     */
    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }

    /**
     * {@inheritdoc}
     */
    public function getPlayers($serverId)
    {
        return $this->get($serverId);
    }

    /**
     * @param int $serverId Server identifier.
     *
     * @return MonitoringPlayers
     */
    protected function get($serverId)
    {
        $callable = function () use ($serverId) {
            try {
                $connection = $this->connector->get($serverId);
                $list = $connection->send('list');
            } catch (\Exception $e) {
                $dto = new MonitoringPlayers($serverId, -1, -1, (int)s_get('caching.monitoring.ttl'));
                \Cache::add("monitoring.{$serverId}", $dto, (int)s_get('caching.monitoring.ttl'));

                return $dto;
            }
            $matches = [];
            preg_match('/.*\s([0-9]+)\/([0-9]+).*/ui', $list, $matches);

            $dto = new MonitoringPlayers($serverId, (int)$matches[1], (int)$matches[2]);
            \Cache::add("monitoring.{$serverId}", $dto, (int)s_get('caching.monitoring.ttl'));

            return $dto;
        };

        return \Cache::get("monitoring.{$serverId}", $callable);
    }
}
