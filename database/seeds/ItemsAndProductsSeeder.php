<?php

use App\Repositories\ItemRepository;
use App\Repositories\ProductRepository;
use Illuminate\Database\Seeder;

class ItemsAndProductsSeeder extends Seeder
{
    private $itemRepository;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(ItemRepository $repository, ProductRepository $productRepository)
    {
        $this->itemRepository = $repository;
        $this->productRepository = $productRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createGrassBlock();
        $this->createTnt();
        $this->createChest();
        $this->createFurnace();
        $this->createSword();
        $this->createHelmet();
        $this->createVip();
    }

    private function createGrassBlock()
    {
        /** @var \App\Models\Item $item */
        $item = $this->itemRepository->create([
            'id' => 5,
            'name' => __('seeding.items.grass'),
            'description' => '',
            'type' => 'item',
            'item' => 2,
            'image' => null,
            'extra' => null
        ]);

        $this->productRepository->create([
            'id' => 14,
            'price' => 2,
            'item_id' => $item->id,
            'server_id' => 1,
            'stack' => 64,
            'category_id' => 1,
            'sort_priority' => 0
        ]);
    }

    private function createTnt()
    {
        /** @var \App\Models\Item $item */
        $item = $this->itemRepository->create([
            'id' => 6,
            'name' => __('seeding.items.tnt'),
            'description' => '',
            'type' => 'item',
            'item' => 46,
            'image' => '784a013771bdf825d1cf26b49897a605.png',
            'extra' => null
        ]);

        $this->productRepository->create([
            'id' => 15,
            'price' => 20,
            'item_id' => $item->id,
            'server_id' => 1,
            'stack' => 16,
            'category_id' => 1,
            'sort_priority' => 0
        ]);
    }

    private function createChest()
    {
        /** @var \App\Models\Item $item */
        $item = $this->itemRepository->create([
            'id' => 7,
            'name' => __('seeding.items.chest'),
            'description' => '',
            'type' => 'item',
            'item' => 54,
            'image' => 'd6c6adf53d0145708ec54a41e8a4e3d8.png',
            'extra' => null
        ]);

        $this->productRepository->create([
            'id' => 16,
            'price' => 15,
            'item_id' => $item->id,
            'server_id' => 1,
            'stack' => 16,
            'category_id' => 1,
            'sort_priority' => 0
        ]);
    }

    private function createFurnace()
    {
        /** @var \App\Models\Item $item */
        $item = $this->itemRepository->create([
            'id' => 8,
            'name' => __('seeding.items.furnace'),
            'description' => '',
            'type' => 'item',
            'item' => 61,
            'image' => '4a69519aa46ee6b5b15bab8abd5139f3.png',
            'extra' => null
        ]);

        $this->productRepository->create([
            'id' => 17,
            'price' => 15,
            'item_id' => $item->id,
            'server_id' => 1,
            'stack' => 32,
            'category_id' => 1,
            'sort_priority' => 0
        ]);
    }

    private function createSword()
    {
        /** @var \App\Models\Item $item */
        $item = $this->itemRepository->create([
            'id' => 9,
            'name' => __('seeding.items.diamond_sword'),
            'description' => '',
            'type' => 'item',
            'item' => 276,
            'image' => '9d8feda602d70231f0297a3b7e436d4b.png',
            'extra' => null
        ]);

        $this->productRepository->create([
            'id' => 18,
            'price' => 67,
            'item_id' => $item->id,
            'server_id' => 1,
            'stack' => 1,
            'category_id' => 2,
            'sort_priority' => 0
        ]);
    }

    private function createHelmet()
    {
        /** @var \App\Models\Item $item */
        $item = $this->itemRepository->create([
            'id' => 10,
            'name' => __('seeding.items.diamond_helmet'),
            'description' => '',
            'type' => 'item',
            'item' => 310,
            'image' => 'd2714c56c81bcc4ff35798832226967f.png',
            'extra' => null
        ]);

        $this->productRepository->create([
            'id' => 19,
            'price' => 54,
            'item_id' => $item->id,
            'server_id' => 2,
            'stack' => 1,
            'category_id' => 3,
            'sort_priority' => 0
        ]);
    }

    private function createVip()
    {
        /** @var \App\Models\Item $item */
        $item = $this->itemRepository->create([
            'id' => 11,
            'name' => __('seeding.items.vip'),
            'description' => '',
            'type' => 'permgroup',
            'item' => 'vip',
            'image' => 'f0c9755f2685d55b7540c941b6f29ff9.png',
            'extra' => null
        ]);

        $this->productRepository->create([
            'id' => 20,
            'price' => 15,
            'item_id' => $item->id,
            'server_id' => 1,
            'stack' => 1,
            'category_id' => 5,
            'sort_priority' => 0
        ]);

        $this->productRepository->create([
            'id' => 21,
            'price' => 100,
            'item_id' => $item->id,
            'server_id' => 1,
            'stack' => 0,
            'category_id' => 5,
            'sort_priority' => 0
        ]);
    }
}
