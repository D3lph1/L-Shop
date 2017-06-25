<?php

namespace App\Services;

use App\Exceptions\ItemNotFoundException;
use App\Repositories\ItemRepository;
use App\Repositories\ProductRepository;

/**
 * Class AdminProducts
 * Service working with products in the admin panel
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services
 */
class AdminProducts
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var ItemRepository
     */
    private $itemRepository;

    /**
     * @param ProductRepository $productRepository
     * @param ItemRepository    $itemRepository
     */
    public function __construct(ProductRepository $productRepository, ItemRepository $itemRepository)
    {
        $this->productRepository = $productRepository;
        $this->itemRepository = $itemRepository;
    }

    /**
     * Create new product
     *
     * @param double $price        New product price.
     * @param int    $stack        New product stack. Stack - the amount of goods sold for one purchase.
     * @param int    $itemId       The identifier of the object to which the product is attached.
     * @param int    $serverId     The identifier of the server on which the product is sold.
     * @param int    $categoryId   The identifier of the category in which the product is sold.
     * @param float  $sortPriority Priority of products sorting.
     *
     * @return mixed
     */
    public function create($price, $stack, $itemId, $serverId, $categoryId, $sortPriority)
    {
        if (!$this->itemRepository->exists($itemId)) {
            throw new ItemNotFoundException($itemId);
        }

        return \DB::transaction(function () use ($price, $stack, $itemId, $serverId, $categoryId, $sortPriority) {
            return $this->productRepository->create([
                'price' => $price,
                'stack' => $stack,
                'item_id' => $itemId,
                'server_id' => $serverId,
                'category_id' => $categoryId,
                'sort_priority' => $sortPriority
            ]);
        });
    }

    /**
     * Edit given product
     *
     * @param int    $productId    Updated product identifier.
     * @param double $price        Product price
     * @param int    $stack        Updated product stack. Stack - the amount of goods sold for one purchase.
     * @param int    $itemId       The identifier of the object to which the product is attached.
     * @param int    $serverId     The identifier of the server on which the product is sold.
     * @param int    $categoryId   The identifier of the category in which the product is sold.
     * @param float  $sortPriority Priority of products sorting.
     *
     * @return bool
     */
    public function edit($productId, $price, $stack, $itemId, $serverId, $categoryId, $sortPriority)
    {
        return \DB::transaction(function () use ($productId, $price, $stack, $itemId, $serverId, $categoryId, $sortPriority) {
            return $this->productRepository->update($productId, [
                'price' => $price,
                'stack' => $stack,
                'item_id' => $itemId,
                'server_id' => $serverId,
                'category_id' => $categoryId,
                'sort_priority' => $sortPriority
            ]);
        });
    }

    /**
     * Delete product with given identifier.
     *
     * @param int $productId Product identifier.
     *
     * @return bool
     */
    public function delete($productId)
    {
        return $this->productRepository->delete($productId);
    }
}
