<?php
declare(strict_types = 1);

namespace App\Services\Purchasing\Distributors;

use App\Entity\Distribution;
use App\Entity\ShoppingCart;
use App\Repository\Distribution\DistributionRepository;
use App\Repository\ShoppingCart\ShoppingCartRepository;
use App\Services\Purchasing\Distributors\ShoppingCartPipeline\OtherPipe;
use App\Services\Purchasing\Distributors\ShoppingCartPipeline\PlayerPipe;
use App\Services\Purchasing\Distributors\ShoppingCartPipeline\SignatureAndAmountPipe;
use App\Services\Purchasing\Distributors\ShoppingCartPipeline\TypePipe;
use Illuminate\Pipeline\Pipeline;

/**
 * Class ShoppingCartDistributor
 * Produces the delivery of products to the player through the plug-in shopping cards reloaded.
 * Implements the pipeline pattern.
 *
 * @see https://github.com/limito/ShoppingCartReloaded
 */
class ShoppingCartDistributor implements Distributor
{
    /**
     * @var ShoppingCartRepository
     */
    private $shoppingCartRepository;

    /**
     * @var DistributionRepository
     */
    private $distributionRepository;

    /**
     * @var Pipeline
     */
    private $pipeline;

    /**
     * @var array
     */
    private $pipes = [
        PlayerPipe::class,
        TypePipe::class,
        SignatureAndAmountPipe::class,
        OtherPipe::class
    ];

    public function __construct(
        ShoppingCartRepository $shoppingCartRepository,
        DistributionRepository $distributionRepository,
        Pipeline $pipeline)
    {
        $this->shoppingCartRepository = $shoppingCartRepository;
        $this->distributionRepository = $distributionRepository;
        $this->pipeline = $pipeline;
    }

    /**
     * {@inheritdoc}
     */
    public function distribute(Distribution $distribution): void
    {
        $this->pipeline
            ->send(new ShoppingCart($distribution))
            ->through($this->pipes)
            ->then(function (ShoppingCart $entity) {
                $this->shoppingCartRepository->create($entity);
                $entity->getDistribution()->setShoppingCart($entity);
                $this->distributionRepository->update($entity->getDistribution());
            });
    }
}
