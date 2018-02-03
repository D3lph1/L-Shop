<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Shop\Cart;

use App\Exceptions\Product\DoesNotExistException;
use App\Repository\Product\ProductRepository;
use App\Services\Cart\Cart;
use App\Services\Cart\Item;

class RemoveHandler
{
    /**
     * @var Cart
     */
    private $cart;

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

        $this->cart->remove(new Item($product, 0));
    }
}
