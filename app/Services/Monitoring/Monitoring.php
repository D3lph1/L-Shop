<?php
declare(strict_types = 1);

namespace App\Services\Monitoring;

use App\Entity\Server;
use App\Repository\Server\ServerRepository;
use App\Services\Caching\CachingRepository;
use App\Services\Monitoring\Drivers\Driver;
use App\Services\Monitoring\Drivers\DTO;
use Psr\Log\LoggerInterface;

class Monitoring
{
    /**
     * @var string
     */
    private $cacheKey = 'monitoring.{server}';

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
     * @return Entity[]
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

    public function monitorOne(Server $server): Entity
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
                $this->logger->warning($e);

                $dto = new DTO(0, 0, true, false);
            }

            $this->cachingRepository->add($key, $dto, $this->ttl);

            return $dto;
        });

        return new Entity($server, $dto->getNow(), $dto->getTotal(), $dto->isDisabled(), $dto->isFailed());
    }

    private function key(int $id): string
    {
        return str_replace('{server}', $id, $this->cacheKey);
    }
}
