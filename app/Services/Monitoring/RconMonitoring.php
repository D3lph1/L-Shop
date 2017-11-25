<?php
declare(strict_types = 1);

namespace App\Services\Monitoring;

use App\DataTransferObjects\MonitoringPlayers;
use App\Services\Rcon\Colorizers\TrimColorizer;
use App\Traits\ContainerTrait;
use D3lph1\MinecraftRconManager\Connector;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Class RconMonitoring
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Services\Monitoring
 */
class RconMonitoring implements MonitoringInterface
{
    use ContainerTrait;

    /**
     * @var Connector
     */
    protected $connector;

    /**
     * RconMonitoring constructor.
     */
    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }

    /**
     * {@inheritdoc}
     */
    public function getPlayers(int $serverId): ?MonitoringPlayers
    {
        return $this->get($serverId);
    }

    protected function get(int $serverId): ?MonitoringPlayers
    {
        $callable = function () use ($serverId) {
            try {
                $connection = $this->connector->get($serverId);
                $list = (string)$connection->send('list');
            } catch (\Exception $e) {
                // If the connection could not be established.
                $dto = new MonitoringPlayers($serverId, -1, -1);
                Cache::add("monitoring.{$serverId}", $dto, (int)s_get('caching.monitoring.ttl'));

                return $dto;
            }
            $matches = [];

            $list = $this->sanitize($list);
            preg_match(s_get('monitoring.rcon.pattern'), $list, $matches);

            if (count($matches) === 0) {
                // If the response came, but was not disassembled correctly.
                Log::warning(
                    "Unable to receive information about monitoring from server `{$serverId}`.
                    Answer received: {$list}"
                );

                return new MonitoringPlayers($serverId);
            }

            $dto = new MonitoringPlayers($serverId, (int)$matches['now'], (int)$matches['total']);
            Cache::add("monitoring.{$serverId}", $dto, (int)s_get('caching.monitoring.ttl'));

            return $dto;
        };

        return Cache::get("monitoring.{$serverId}", $callable);
    }

    /**
     * Clear string from minecraft markup.
     */
    private function sanitize(string $string): string
    {
        /** @var TrimColorizer $colorizer */
        $colorizer = $this->make(TrimColorizer::class);

        return $colorizer->colorize($string);
    }
}
