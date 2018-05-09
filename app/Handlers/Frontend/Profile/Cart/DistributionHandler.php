<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Profile\Cart;

use App\Exceptions\Distributor\DistributionNotFoundException;
use App\Exceptions\Distributor\DistributorNotFoundException;
use App\Repository\Distribution\DistributionRepository;
use App\Services\Purchasing\Distributors\Pool;
use App\Services\Purchasing\PurchaseCompleter;

class DistributionHandler
{
    /**
     * @var DistributionRepository
     */
    private $repository;

    /**
     * @var Pool
     */
    private $distributors;

    public function __construct(DistributionRepository $repository, Pool $pool)
    {
        $this->repository = $repository;
        $this->distributors = $pool;
    }

    public function handle(int $distributionId): void
    {
        $distribution = $this->repository->find($distributionId);
        if ($distribution === null) {
            throw DistributionNotFoundException::byId($distributionId);
        }

        $distributorClass = $distribution
            ->getPurchaseItem()
            ->getProduct()
            ->getCategory()
            ->getServer()
            ->getDistributor();

        // Retrieve distributor for server of this product.
        $distributor = $this->distributors->retrieveByName($distributorClass);

        if ($distributor === null) {
            throw DistributorNotFoundException::byClassName($distributorClass);
        }

        $distributor->distribute($distribution);
    }
}
