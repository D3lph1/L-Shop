<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Products;

use App\Exceptions\Product\ProductNotFoundException;
use App\Repository\Product\ProductRepository;

class DeleteHandler
{
    /**
     * @var ProductRepository
     */
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $productId
     *
     * @throws ProductNotFoundException
     */
    public function handle(int $productId): void
    {
        $product = $this->repository->find($productId);
        if ($product === null) {
            throw ProductNotFoundException::byId($productId);
        }

        $this->repository->remove($product);
    }
}
