<?php

namespace App\Services;

use App\DataTransferObjects\Admin\Product;
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
     * @param Product $dto
     *
     * @return mixed
     */
    public function create(Product $dto)
    {
        if (!$this->itemRepository->exists($dto->getItemId())) {
            throw new ItemNotFoundException($dto->getItemId());
        }

        return \DB::transaction(function () use ($dto) {
            return $this->productRepository->create([
                'price' => $dto->getPrice(),
                'stack' => $dto->getStack(),
                'item_id' => $dto->getItemId(),
                'server_id' => $dto->getServerId(),
                'category_id' => $dto->getCategoryId(),
                'sort_priority' => $dto->getSortPriority()
            ]);
        });
    }

    /**
     * Edit given product
     *
     * @param Product $dto
     *
     * @return bool
     */
    public function edit(Product $dto)
    {
        return \DB::transaction(function () use ($dto) {
            return $this->productRepository->update($dto->getId(), [
                'price' => $dto->getPrice(),
                'stack' => $dto->getStack(),
                'item_id' => $dto->getItemId(),
                'server_id' => $dto->getServerId(),
                'category_id' => $dto->getCategoryId(),
                'sort_priority' => $dto->getSortPriority()
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
