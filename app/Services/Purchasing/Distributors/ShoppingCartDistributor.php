<?php
declare(strict_types = 1);

namespace App\Services\Purchasing\Distributors;

use App\Entity\Distribution;
use App\Entity\ShoppingCart;
use App\Repository\ShoppingCart\ShoppingCartRepository;
use App\Services\Purchasing\Distributors\ShoppingCartPipeline\OtherPipe;
use App\Services\Purchasing\Distributors\ShoppingCartPipeline\PlayerPipe;
use App\Services\Purchasing\Distributors\ShoppingCartPipeline\SignatureAndAmountPipe;
use App\Services\Purchasing\Distributors\ShoppingCartPipeline\TypePipe;
use Illuminate\Pipeline\Pipeline;

class ShoppingCartDistributor implements Distributor
{
    /**
     * @var ShoppingCartRepository
     */
    private $repository;

    /**
     * @var Pipeline
     */
    private $pipeline;

    private $pipes = [
        PlayerPipe::class,
        TypePipe::class,
        SignatureAndAmountPipe::class,
        OtherPipe::class
    ];

    public function __construct(ShoppingCartRepository $repository, Pipeline $pipeline)
    {
        $this->repository = $repository;
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
                $this->repository->create($entity);
            });
    }
}
