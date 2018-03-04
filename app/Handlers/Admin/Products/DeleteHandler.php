<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Products;

use App\Exceptions\Product\DoesNotExistException;
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

    public function handle(int $productId): void
    {
        $product = $this->repository->find($productId);
        if ($product === null) {
            throw new DoesNotExistException($productId);
        }

        $this->repository->remove($product);
    }
}
