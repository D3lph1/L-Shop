<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Control\Api;

use App\DataTransferObjects\Admin\Control\Api\Save;
use App\Exceptions\UnexpectedValueException;
use App\Services\Settings\Settings;
use Illuminate\Contracts\Config\Repository;

class SaveHandler
{
    /**
     * @var Settings
     */
    private $settings;

    /**
     * @var Repository
     */
    private $config;

    public function __construct(Settings $settings, Repository $config)
    {
        $this->settings = $settings;
        $this->config = $config;
    }

    public function handle(Save $dto): void
    {
        if (!in_array($dto->getAlgorithm(), $this->config->get('system.api.algorithms'))) {
            throw new UnexpectedValueException("Algorithm {$dto->getAlgorithm()} not supported");
        }

        $this->settings->setArray([
            'api' => [
                'enabled' => $dto->isApiEnabled(),
                'key' => $dto->getKey(),
                'delimiter' => $dto->getDelimiter(),
                'algorithm' => $dto->getAlgorithm(),
                'login_enabled' => $dto->isApiAuthEnabled(),
                'register_enabled' => $dto->isApiRegisterEnabled(),
                'auth' => [
                    'sashok724sV3Launcher' => [
                        'enabled' => $dto->isSashok724sV3LauncherEnabled(),
                        'format' => $dto->getSashok724sV3LauncherFormat(),
                        'ips' => json_encode($dto->getSashok724sV3LauncherIPs())
                    ]
                ]
            ]
        ]);
        $this->settings->save();
    }
}
