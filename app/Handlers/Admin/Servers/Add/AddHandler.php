<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Servers\Add;

use App\DataTransferObjects\Admin\Servers\Add\Add;
use App\Entity\Category;
use App\Entity\Server;
use App\Events\Server\ServerCreatedEvent;
use App\Exceptions\Distributor\DistributorNotFoundException;
use App\Repository\Server\ServerRepository;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;

class AddHandler
{
    /**
     * @var ServerRepository
     */
    private $repository;

    /**
     * @var Repository
     */
    private $config;

    /**
     * @var Dispatcher
     */
    private $eventDispatcher;

    public function __construct(ServerRepository $repository, Repository $config, Dispatcher $eventDispatcher)
    {
        $this->repository = $repository;
        $this->config = $config;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param Add $dto
     *
     * @throws DistributorNotFoundException
     */
    public function handle(Add $dto): void
    {
        if (!in_array($dto->getDistributor(), $this->config->get('purchasing.distribution.distributors'))) {
            throw new DistributorNotFoundException("Distributor {$dto->getDistributor()} does not registered in system");
        }

        $server = (new Server($dto->getName(), $dto->getDistributor()))
            ->setIp($dto->getIp())
            ->setPort($dto->getPort())
            ->setPassword($dto->getPassword())
            ->setMonitoringEnabled($dto->isMonitoringEnabled())
            ->setEnabled($dto->isServerEnabled());

        foreach ($dto->getCategories() as $category) {
            $server->getCategories()->add(new Category($category, $server));
        }

        $this->repository->create($server);
        $this->eventDispatcher->dispatch(new ServerCreatedEvent($server));
    }
}
