<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Shop\Cart;

use App\Exceptions\ForbiddenException;
use App\Exceptions\Product\ProductNotFoundException;
use App\Repository\Product\ProductRepository;
use App\Services\Auth\Auth;
use App\Services\Cart\Cart;
use App\Services\Cart\Item;
use App\Services\Server\Persistence\Persistence;
use App\Services\Server\ServerAccess;

class PutHandler
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

    /**
     * @var Persistence
     */
    private $persistence;

    public function __construct(Auth $auth, Cart $cart, ProductRepository $productRepository, Persistence $persistence)
    {
        $this->auth = $auth;
        $this->cart = $cart;
        $this->productRepository = $productRepository;
        $this->persistence = $persistence;
    }

    /**
     * @param int $productId
     *
     * @return int|null Amount of items in cart after procedure completed. Null - if server not persistent.
     * @throws ProductNotFoundException
     * @throws ForbiddenException
     */
    public function handle(int $productId): ?int
    {
        $product = $this->productRepository->find($productId);
        if ($product === null) {
            throw ProductNotFoundException::byId($productId);
        }

        $server = $product->getCategory()->getServer();
        if (!ServerAccess::isUserHasAccessTo($this->auth->getUser(), $server)) {
            throw new ForbiddenException("Server {$server} is disabled and the user does not have permissions to make this action");
        }

        $this->cart->put(new Item($product, 1));

        return $this->persistence->retrieve() ? count($this->cart->retrieveServer($this->persistence->retrieve())) : null;
    }
}
