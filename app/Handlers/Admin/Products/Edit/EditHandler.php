<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Products\Edit;

use App\DataTransferObjects\Admin\Products\Edit\Edit;
use App\Exceptions\Category\CategoryNotFoundException;
use App\Exceptions\Item\ItemNotFoundException;
use App\Exceptions\Product\ProductNotFoundException;
use App\Repository\Category\CategoryRepository;
use App\Repository\Item\ItemRepository;
use App\Repository\Product\ProductRepository;

class EditHandler
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
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(
        ProductRepository $repository,
        ItemRepository $itemRepository,
        CategoryRepository $categoryRepository)
    {
        $this->productRepository = $repository;
        $this->itemRepository = $itemRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param Edit $dto
     *
     * @throws ProductNotFoundException
     * @throws ItemNotFoundException
     * @throws CategoryNotFoundException
     */
    public function handle(Edit $dto): void
    {
        $product = $this->productRepository->find($dto->getProduct());
        if ($product === null) {
            throw ProductNotFoundException::byId($dto->getProduct());
        }

        $item = $this->itemRepository->find($dto->getItem());
        if ($item === null) {
            throw ItemNotFoundException::byId($dto->getItem());
        }

        $category = $this->categoryRepository->find($dto->getCategory());
        if ($category === null) {
            throw CategoryNotFoundException::byId($dto->getCategory());
        }

        $product
            ->setItem($item)
            ->setCategory($category)
            ->setPrice($dto->getPrice())
            ->setStack($dto->getStack())
            ->setSortPriority($dto->getSortPriority())
            ->setHidden($dto->isHidden());

        $this->productRepository->update($product);
    }
}
