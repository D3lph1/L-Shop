<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Shop\Cart;

use App\Exceptions\ForbiddenException;
use App\Exceptions\Product\ProductNotFoundException;
use App\Repository\Product\ProductRepository;
use App\Services\Auth\Auth;
use App\Services\Cart\Cart;
use App\Services\Cart\Item;
use App\Services\Server\ServerAccess;

class RemoveHandler
{
    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var Cart
     */
    private $cart;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(Auth $auth, Cart $cart, ProductRepository $productRepository)
    {
        $this->auth = $auth;
        $this->cart = $cart;
        $this->productRepository = $productRepository;
    }

    /**
     * @param int $productId
     *
     * @throws ProductNotFoundException
     */
    public function handle(int $productId): void
    {
        $product = $this->productRepository->find($productId);
        if ($product === null) {
            throw ProductNotFoundException::byId($productId);
        }

        $server = $product->getCategory()->getServer();
        if (!ServerAccess::isUserHasAccessTo($this->auth->getUser(), $server)) {
            throw new ForbiddenException("Server {$server} is disabled and the user does not have permissions to make this action");
        }

        $this->cart->remove(new Item($product, 0));
    }
}
