<?php
declare(strict_types = 1);

namespace App\Services\Cart;

use App\Entity\Server;
use App\Repository\Product\ProductRepository;
use App\Services\Cart\Storage\Storage;

/**
 * Class Cart
 * Implements the functionality of the shopping cart.
 * In the context of this package, the "item" is an instance of class {@see Item}.
 */
class Cart
{
    /**
     * @var Storage
     */
    private $storage;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(Storage $storage, ProductRepository $productRepository)
    {
        $this->storage = $storage;
        $this->productRepository = $productRepository;
    }

    /**
     * Put an item in the shopping cart.
     *
     * @param Item $item
     */
    public function put(Item $item): void
    {
        $this->storage->put(
            $item->getProduct()->getCategory()->getServer()->getId(),
            $item->getProduct()->getId(),
            $item->getAmount()
        );
    }

    /**
     * Gets items from the specified server's shopping cart.
     *
     * @param Server $server
     *
     * @return Item[]
     */
    public function retrieveServer(Server $server): array
    {
        $server = $this->storage->retrieveServer($server->getId());
        if ($server === null) {
            return [];
        }
        $result = [];
        foreach ($server as $productId => $productAmount) {
            $product = $this->productRepository->find($productId);
            if ($product !== null) {
                $result[] = new Item($product, $productAmount);
            }
        }

        return $result;
    }

    /**
     * Checks for the presence of an item in the shopping cart.
     *
     * @param Item $item
     *
     * @return bool
     */
    public function exist(Item $item): bool
    {
        return $this->storage->retrieve($item->getProduct()->getCategory()->getServer()->getId(), $item->getProduct()->getId()) !== null;
    }

    /**
     * Returns the number of items in the shopping cart.
     *
     * @param Server $server
     *
     * @return int
     */
    public function countServer(Server $server)
    {
        $server = $this->storage->retrieveServer($server->getId());
        if ($server === null) {
            return 0;
        }

        return count($server);
    }

    /**
     * Removes an item from the shopping cart.
     *
     * @param Item $item
     *
     * @return bool True - successfully removed.
     */
    public function remove(Item $item): bool
    {
        return $this->storage->remove($item->getProduct()->getCategory()->getServer()->getId(), $item->getProduct()->getId());
    }
}
