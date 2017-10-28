<?php
declare(strict_types = 1);

namespace App\TransactionScripts;

use App\DataTransferObjects\Admin\EditedProduct;
use App\DataTransferObjects\Product;
use App\Exceptions\ItemNotFoundException;
use App\Exceptions\Product\NotFoundException;
use App\Models\Category\CategoryInterface;
use App\Models\Product\ProductInterface;
use App\Models\Server\ServerInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Item\ItemRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Traits\ContainerTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/**
 * Class Products
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\TransactionScripts
 */
class Products
{
    use ContainerTrait;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var ItemRepositoryInterface
     */
    private $itemRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ItemRepositoryInterface $itemRepository)
    {
        $this->productRepository = $productRepository;
        $this->itemRepository = $itemRepository;
    }

    public function create(ProductInterface $entity): bool
    {
        if (!$this->itemRepository->exists($entity->getItemId())) {
            throw new ItemNotFoundException($entity->getItemId());
        }

        return (bool)DB::transaction(function () use ($entity) {
            return $this->productRepository->create($entity);
        });
    }

    public function informationForList(?string $orderBy, ?string $orderType, ?string $filter): LengthAwarePaginator
    {
        if (is_null($orderBy)) {
            $orderBy = 'products.id';
        }

        if (is_null($orderType)) {
            $orderType = 'ASC';
        }

        return $this->productRepository->withCategoryWithServerPaginated(
            ['products.id', 'products.price', 'products.stack'],
            ['items.image', 'items.name', 'items.type'],
            ['name'],
            ['name'],
            $orderBy,
            $orderType,
            $filter
        );
    }

    public function informationForEdit(int $productId): EditedProduct
    {
        /** @var ProductInterface $product */
        $product = $this->productRepository->withItems($productId,
            ['id', 'price', 'stack', 'item_id', 'category_id', 'sort_priority'],
            ['name', 'type']
        );

        if (!$product) {
            throw new NotFoundException($productId);
        }

        $items = $this->itemRepository->all(['id', 'name', 'type']);

        /** @var CategoryRepositoryInterface $categoryRepository */
        $categoryRepository = $this->make(CategoryRepositoryInterface::class);
        /** @var ServerInterface[] $servers */
        $categories = $categoryRepository->allWithServers(['id', 'name'], ['name']);

        $currentCategory = null;
        /** @var CategoryInterface $category */
        foreach ($categories as $category) {
            if ($category->getId() === $product->getCategoryId()) {
                $currentCategory = $category;

                break;
            }
        }

        return new EditedProduct($product, $items, $categories, $currentCategory);
    }

    public function edit(int $productId, Product $dto): bool
    {
        if (!$this->productRepository->exists($productId)) {
            throw new NotFoundException($productId);
        }

        return (bool)DB::transaction(function () use ($productId, $dto) {
            /** @var ProductInterface $entity */
            $entity = $this->make(ProductInterface::class);
            $entity
                ->setPrice($dto->getPrice())
                ->setItemId($dto->getItemId())
                ->setServerId($dto->getServerId())
                ->setStack($dto->getStack())
                ->setCategoryId($dto->getCategoryId())
                ->setSortPriority($dto->getSortPriority());

            return $this->productRepository->update($productId, $entity);
        });
    }

    public function delete(int $productId): bool
    {
        return $this->productRepository->delete($productId);
    }
}
