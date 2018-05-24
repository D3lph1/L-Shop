<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Control\Api;

use App\DataTransferObjects\Admin\Control\Api\VisitResult;
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
            ->setApiEnabled($this->settings->get('api.enabled')->getValue(DataType::BOOL))
            ->setKey($this->settings->get('api.key')->getValue())
            ->setDelimiter($this->settings->get('api.delimiter')->getValue())
            ->setAlgorithm($this->settings->get('api.algorithm')->getValue())
            ->setApiAuthEnabled($this->settings->get('api.login_enabled')->getValue(DataType::BOOL))
            ->setApiRegisterEnabled($this->settings->get('api.register_enabled')->getValue(DataType::BOOL))
            ->setSashok724SV3LauncherEnabled($this->settings->get('api.auth.sashok724sV3Launcher.enabled')->getValue(DataType::BOOL))
            ->setSashok724SV3LauncherFormat($this->settings->get('api.auth.sashok724sV3Launcher.format')->getValue())
            ->setSashok724SV3LauncherIPs($this->settings->get('api.auth.sashok724sV3Launcher.ips')->getValue(DataType::JSON));
    }
}
