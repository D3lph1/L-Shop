<?php
declare(strict_types = 1);

use App\DataTransferObjects\Item;
use App\DataTransferObjects\Product;
use App\Models\Item\ItemInterface;
use App\Models\Product\ProductInterface;
use App\Repositories\Item\ItemRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Database\Seeder;

/**
 * Class ItemsAndProductsSeeder
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 */
class ItemsAndProductsSeeder extends Seeder
{
    use \App\Traits\ContainerTrait;

    /**
     * @var ItemRepositoryInterface
     */
    private $itemRepository;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(ItemRepositoryInterface $repository, ProductRepositoryInterface $productRepository)
    {
        $this->itemRepository = $repository;
        $this->productRepository = $productRepository;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createGrassBlock();
        $this->createTnt();
        $this->createChest();
        $this->createFurnace();
        $this->createSword();
        $this->createHelmet();
        $this->createVip();
    }

    private function createGrassBlock(): void
    {
        /** @var ItemInterface $item */
        $item = $this->itemRepository->create(
            $this->make(ItemInterface::class)
                ->setId(5)
                ->setName(__('seeding.items.grass'))
                ->setDescription('')
                ->setType('item')
                ->setItem('2')
                ->setImage(null)
                ->setExtra(null)
        );

        $this->productRepository->create(
            $this->make(ProductInterface::class)
                ->setId(14)
                ->setPrice(2)
                ->setItemId($item->getId())
                ->setServerId(1)
                ->setStack(64)
                ->setCategoryId(1)
                ->setSortPriority(0)
        );
    }

    private function createTnt(): void
    {
        /** @var ItemInterface $item */
        $item = $this->itemRepository->create(
            $this->make(ItemInterface::class)
                ->setId(6)
                ->setName(__('seeding.items.tnt'))
                ->setDescription('')
                ->setType('item')
                ->setItem('46')
                ->setImage('784a013771bdf825d1cf26b49897a605.png')
                ->setExtra(null)
        );

        $this->productRepository->create(
            $this->make(ProductInterface::class)
                ->setId(15)
                ->setPrice(20)
                ->setItemId($item->getId())
                ->setServerId(1)
                ->setStack(16)
                ->setCategoryId(1)
                ->setSortPriority(0)
            );
    }

    private function createChest(): void
    {
        /** @var ItemInterface $item */
        $item = $this->itemRepository->create(
            $this->make(ItemInterface::class)
                ->setId(7)
                ->setName(__('seeding.items.chest'))
                ->setDescription('')
                ->setType('item')
                ->setItem('54')
                ->setImage('d6c6adf53d0145708ec54a41e8a4e3d8.png')
                ->setExtra(null)
        );

        $this->productRepository->create(
            $this->make(ProductInterface::class)
                ->setId(16)
                ->setPrice(15)
                ->setItemId($item->getId())
                ->setServerId(1)
                ->setStack(16)
                ->setCategoryId(1)
                ->setSortPriority(0)
        );
    }

    private function createFurnace(): void
    {
        /** @var ItemInterface $item */
        $item = $this->itemRepository->create(
            $this->make(ItemInterface::class)
                ->setId(8)
                ->setName(__('seeding.items.furnace'))
                ->setDescription('')
                ->setType('item')
                ->setItem('61')
                ->setImage('4a69519aa46ee6b5b15bab8abd5139f3.png')
                ->setExtra(null)
        );

        $this->productRepository->create(
            $this->make(ProductInterface::class)
                ->setId(17)
                ->setPrice(15)
                ->setItemId($item->getId())
                ->setServerId(1)
                ->setStack(32)
                ->setCategoryId(1)
                ->setSortPriority(0)
        );
    }

    private function createSword(): void
    {
        /** @var ItemInterface $item */
        $item = $this->itemRepository->create(
            $this->make(ItemInterface::class)
                ->setId(9)
                ->setName(__('seeding.items.diamond_sword'))
                ->setDescription('')
                ->setType('item')
                ->setItem('276')
                ->setImage('9d8feda602d70231f0297a3b7e436d4b.png')
                ->setExtra(null)
        );

        $this->productRepository->create(
            $this->make(ProductInterface::class)
                ->setId(18)
                ->setPrice(67)
                ->setItemId($item->getId())
                ->setServerId(1)
                ->setStack(1)
                ->setCategoryId(2)
                ->setSortPriority(0)
        );
    }

    private function createHelmet(): void
    {
        /** @var ItemInterface $item */
        $item = $this->itemRepository->create(
            $this->make(ItemInterface::class)
                ->setId(10)
                ->setName(__('seeding.items.diamond_helmet'))
                ->setDescription('')
                ->setType('item')
                ->setItem('310')
                ->setImage('d2714c56c81bcc4ff35798832226967f.png')
                ->setExtra(null)
        );

        $this->productRepository->create(
            $this->make(ProductInterface::class)
                ->setId(19)
                ->setPrice(54)
                ->setItemId($item->getId())
                ->setServerId(2)
                ->setStack(1)
                ->setCategoryId(3)
                ->setSortPriority(0)
        );
    }

    private function createVip(): void
    {
        /** @var ItemInterface $item */
        $item = $this->itemRepository->create(
            $this->make(ItemInterface::class)
                ->setId(11)
                ->setName(__('seeding.items.vip'))
                ->setDescription('')
                ->setType('permgroup')
                ->setItem('vip')
                ->setImage('f0c9755f2685d55b7540c941b6f29ff9.png')
                ->setExtra(null)
        );

        $this->productRepository->create(
            $this->make(ProductInterface::class)
                ->setId(20)
                ->setPrice(15)
                ->setItemId($item->getId())
                ->setServerId(1)
                ->setStack(1)
                ->setCategoryId(5)
                ->setSortPriority(0)
        );

        $this->productRepository->create(
            $this->make(ProductInterface::class)
                ->setId(21)
                ->setPrice(100)
                ->setItemId($item->getId())
                ->setServerId(1)
                ->setStack(0)
                ->setCategoryId(5)
                ->setSortPriority(0)
        );
    }
}
