<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Profile\Cart;

use App\Exceptions\Distributor\DistributionNotFoundException;
use App\Exceptions\Distributor\DistributorNotFoundException;
use App\Exceptions\Distributor\NotAttemptedException;
use App\Repository\Distribution\DistributionRepository;
use App\Services\Purchasing\Distributors\Attempting;
use App\Services\Purchasing\Distributors\Pool;
use App\Services\Purchasing\PurchaseCompleter;

/**
 * Class DistributionHandler
 * Responsible for distributing products to the player.
 */
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

    /**
     * Tries to give products to the player.
     *
     * @param int $distributionId
     *
     * @throws DistributorNotFoundException
     * @throws NotAttemptedException
     */
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

        // If the class does not implement the interface, then it can not be passed out of this context.
        if (!($distribution instanceof Attempting)) {
            throw new NotAttemptedException($distributorClass);
        }

        $distributor->distribute($distribution);
    }
}
