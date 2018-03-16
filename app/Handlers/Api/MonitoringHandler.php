<?php
declare(strict_types = 1);

namespace App\Handlers\Api;

use App\DataTransferObjects\Api\Monitoring as DTO;
use App\Services\Monitoring\Monitoring;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;

class MonitoringHandler
{
    /**
     * @var Monitoring
     */
    private $monitoring;

    /**
     * @var Settings
     */
    private $settings;

    public function __construct(Monitoring $monitoring, Settings $settings)
    {
        $this->monitoring = $monitoring;
        $this->settings = $settings;
    }

    /**
     * @return DTO[]
     */
    public function handle(): array
    {
        if (!$this->settings->get('system.monitoring.enabled')->getValue(DataType::BOOL)) {
            return [];
        }

        $servers = $this->monitoring->monitorAll();
        $result = [];
        foreach ($servers as $server) {
            $result[] = new DTO($server);
        }

        return $result;
    }
}
