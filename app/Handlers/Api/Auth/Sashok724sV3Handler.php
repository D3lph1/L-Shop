<?php
declare(strict_types = 1);

namespace App\Handlers\Api\Auth;

use App\Exceptions\Api\InvalidIpAddressException;
use App\Exceptions\ForbiddenException;
use App\Services\Auth\Auth;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;
use Psr\Log\LoggerInterface;

class Sashok724sV3Handler
{
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

    /**
     * @param string $username
     * @param string $password
     * @param string $ip
     *
     * @return null|string
     * @throws ForbiddenException
     * @throws InvalidIpAddressException
     */
    public function handle(string $username, string $password, string $ip): ?string
    {
        if (!$this->settings->get('api.auth.sashok724sV3Launcher.enabled')->getValue(DataType::BOOL)) {
            $e = new ForbiddenException('Possibility of API authentication for Sashok724\'s v3 launcher is disabled');
            $this->logger->warning($e);

            throw $e;
        }
        $IPs = $this->settings->get('api.auth.sashok724sV3Launcher.ips')->getValue(DataType::JSON);
        if (count($IPs) !== 0 && !in_array($ip, $IPs)) {
            $e = new InvalidIpAddressException("IP-address {$ip} not found in the whitelist");
            $this->logger->warning($e);

            throw $e;
        }

        if ($this->auth->authenticate($username, $password, false)) {
            return $this->buildResponse($this->settings->get('api.auth.sashok724sV3Launcher.format')->getValue());
        }

        return null;
    }

    private function buildResponse(string $format): string
    {
        return str_replace('{username}', $this->auth->getUser()->getUsername(), $format);
    }
}
