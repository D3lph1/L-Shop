<?php

namespace App\Services;

use App\Exceptions\ItemNotFoundException;
use App\Repositories\ItemRepository;
use App\Repositories\ProductRepository;

/**
 * Class AdminProducts
 * Service working with products in the admin panel
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
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
     * @param double $price
     * @param int $stack
     * @param int $itemId
     * @param int $serverId
     * @param int $categoryId
     *
     * @throws ItemNotFoundException
     *
     * @return mixed
     */
    public function create($price, $stack, $itemId, $serverId, $categoryId)
    {
        if (!$this->itemRepository->exists($itemId)) {
            throw new ItemNotFoundException($itemId);
        }

        return \DB::transaction(function () use ($price, $stack, $itemId, $serverId, $categoryId) {
            return $this->productRepository->create([
                'price' => $price,
                'stack' => $stack,
                'item_id' => $itemId,
                'server_id' => $serverId,
                'category_id' => $categoryId
            ]);
        });
    }

    /**
     * Edit given product
     *
     * @param int    $productId
     * @param double $price
     * @param int    $stack
     * @param int    $itemId
     * @param int    $serverId
     * @param int    $categoryId
     *
     * @return bool
     */
    public function edit($productId, $price, $stack, $itemId, $serverId, $categoryId)
    {
        return \DB::transaction(function () use ($productId, $price, $stack, $itemId, $serverId, $categoryId) {
            return $this->productRepository->update($productId, [
                'price' => $price,
                'stack' => $stack,
                'item_id' => $itemId,
                'server_id' => $serverId,
                'category_id' => $categoryId
            ]);
        });
    }

    /**
     * Delete product
     *
     * @param $productId
     *
     * @return bool|null
     */
    public function delete($productId)
    {
        return $this->productRepository->delete($productId);
    }
}
