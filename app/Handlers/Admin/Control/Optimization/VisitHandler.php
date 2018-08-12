<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Control\Optimization;

use App\DataTransferObjects\Admin\Control\Optimization\VisitResult;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;

class VisitHandler
{
    /**
     * @var Settings
     */
    private $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function handle(): VisitResult
    {
        return (new VisitResult())
            ->setMonitoringTtl($this->settings->get('system.monitoring.rcon.ttl')->getValue(DataType::INT));
    }
}
