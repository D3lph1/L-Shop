<?php
declare(strict_types = 1);

namespace App\Handlers\Api\Auth;

use App\Exceptions\ForbiddenException;
use App\Services\Auth\Auth;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;
use Psr\Log\LoggerInterface;

class Sashok724sV3Handler
{
    private const RESPONSE = 'OK:{username}';

    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var Settings
     */
    private $settings;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(Auth $auth, Settings $settings, LoggerInterface $logger)
    {
        $this->auth = $auth;
        $this->settings = $settings;
        $this->logger = $logger;
    }

    public function handle(string $username, string $password): ?string
    {
        if (!$this->settings->get('api.auth.sashok724sV3Launcher.enabled')->getValue(DataType::BOOL)) {
            $e = new ForbiddenException('Possibility of API authentication for Sashok724\'s v3 launcher is disabled');
            $this->logger->warning($e);

            throw $e;
        }

        if ($this->auth->authenticate($username, $password, false)) {
            return $this->buildResponse();
        }

        return null;
    }

    private function buildResponse(): string
    {
        return str_replace('{username}', $this->auth->getUser()->getUsername(), self::RESPONSE);
    }
}
