<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Shop\Catalog;

use App\DataTransferObjects\Frontend\Shop\Catalog\Purchase as ResultDTO;
use App\DataTransferObjects\Frontend\Shop\Purchase;
use App\Exceptions\Product\ProductNotFoundException;
use App\Repository\Product\ProductRepository;
use App\Services\Purchasing\PurchaseProcessor;

class PurchaseHandler
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var PurchaseProcessor
     */
    private $processor;

    public function __construct(ProductRepository $productRepository, PurchaseProcessor $processor)
    {
        $this->productRepository = $productRepository;
        $this->processor = $processor;
    }

    /**
     * @param int         $productId
     * @param int         $amount
     * @param null|string $username
     * @param string      $ip
     *
     * @return ResultDTO
     *
     * @throws ProductNotFoundException
     */
    public function handle(int $productId, int $amount, ?string $username, string $ip): ResultDTO
    {
        $product = $this->productRepository->find($productId);
        if ($product === null) {
            throw ProductNotFoundException::byId($productId);
        }

        $DTO = new Purchase($product, $amount);

        return $this->processor->process([$DTO], $username, $ip);
    }
}
