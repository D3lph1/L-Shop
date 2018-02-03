<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Shop\Cart;

use App\Exceptions\Product\DoesNotExistException;
use App\Repository\Product\ProductRepository;
use App\Services\Cart\Cart;
use App\Services\Cart\Item;

class PutHandler
{
    /**
     * @var Cart
     */
    private $cart;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(Cart $cart, ProductRepository $productRepository)
    {
        $this->cart = $cart;
        $this->productRepository = $productRepository;
    }

    public function handle(int $productId): void
    {
        $product = $this->productRepository->find($productId);
        if ($product === null) {
            throw new DoesNotExistException($productId);
        }
        $this->cart->put(new Item($product, 1));
    }
}
