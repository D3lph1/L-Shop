<?php
declare(strict_types = 1);

namespace App\Services\Monitoring;

use App\Entity\Server;
use App\Repository\Server\ServerRepository;
use App\Services\Caching\CachingRepository;
use App\Services\Monitoring\Drivers\Driver;
use App\Services\Monitoring\Drivers\DTO;
use Psr\Log\LoggerInterface;

/**
 * Class Monitoring
 * Keeps the logic of obtaining information about online gaming servers.
 */
class Monitoring
{
    private const CACHE_KEY = 'monitoring.{server}';

    /**
     * @var ServerRepository
     */
    private $repository;

    /**
     * @var Driver
     */
    private $driver;

    /**
     * @var CachingRepository
     */
    private $cachingRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var float
     */
    private $ttl;

    public function __construct(
        ServerRepository $repository,
        Driver $driver,
        CachingRepository $cachingRepository,
        LoggerInterface $logger,
        float $ttl)
    {
        $this->repository = $repository;
        $this->driver = $driver;
        $this->cachingRepository = $cachingRepository;
        $this->logger = $logger;
        $this->ttl = $ttl;
    }

    /**
     * Gets statistical information for all servers that have the monitoring option enabled.
     *
     * @return Statistic[]
     */
    public function monitorAll(): array
    {
        $servers = $this->repository->findWithEnabledMonitoring();
        $result = [];
        foreach ($servers as $server) {
            $result[] = $this->monitorOne($server);
        }

        return $result;
    }

    /**
     * Gets information about statistics for a specific server.
     *
     * @param Server $server
     *
     * @return Statistic
     */
    public function monitorOne(Server $server): Statistic
    {
        $key = $this->key($server->getId());

        /** @var DTO $dto */
        $dto = $this->cachingRepository->get($key, function () use ($key, $server) {
            try {
                $dto = $this->driver->retrieve($server);
            } catch (ResponseException $e) {
                $this->logger->error($e);

                $dto = new DTO(0, 0, false, true);
            } catch (MonitoringException $e) {
                $this->logger->error($e);

                $dto = new DTO(0, 0, true, false);
            }

            $this->cachingRepository->add($key, $dto, $this->ttl);

            return $dto;
        });

        return new Statistic($server, $dto->getNow(), $dto->getTotal(), $dto->isDisabled(), $dto->isFailed());
    }

    private function key(int $id): string
    {
        return str_replace('{server}', $id, self::CACHE_KEY);
    }
}
