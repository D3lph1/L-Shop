<?php
declare(strict_types = 1);

use App\Entity\EnchantmentItem;
use App\Entity\Item;
use App\Entity\Product;
use App\Repository\Category\CategoryRepository;
use App\Repository\Enchantment\EnchantmentRepository;
use App\Repository\Item\ItemRepository;
use App\Repository\Product\ProductRepository;
use App\Services\Item\Enchantment\Enchantments;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run(
        ProductRepository $productRepository,
        ItemRepository $itemRepository,
        CategoryRepository $categoryRepository,
        EnchantmentRepository $enchantmentRepository): void
    {
        $productRepository->deleteAll();
        $itemRepository->deleteAll();

        $productRepository->create(new Product(
            new Item(__('seeding.items.grass'), \App\Services\Item\Type::ITEM, '2'),
            $categoryRepository->findAll()[0],
            2,
            64
        ));
        $productRepository->create(new Product(
            (new Item(__('seeding.items.tnt'), \App\Services\Item\Type::ITEM, '46'))
                ->setImage('784a013771bdf825d1cf26b49897a605.png'),
            $categoryRepository->findAll()[0],
            20,
            16
        ));
        $productRepository->create(new Product(
            (new Item(__('seeding.items.chest'), \App\Services\Item\Type::ITEM, '54'))
                ->setImage('d6c6adf53d0145708ec54a41e8a4e3d8.png'),
            $categoryRepository->findAll()[0],
            15,
            16
        ));
        $productRepository->create(new Product(
            (new Item(__('seeding.items.furnace'), \App\Services\Item\Type::ITEM, '61'))
                ->setImage('4a69519aa46ee6b5b15bab8abd5139f3.png'),
            $categoryRepository->findAll()[0],
            15,
            32
        ));

        $item = (new Item(__('seeding.items.diamond_sword'), \App\Services\Item\Type::ITEM, '276'))
            ->setImage('9d8feda602d70231f0297a3b7e436d4b.png');

        $item->addEnchantmentItem(
            (new EnchantmentItem($enchantmentRepository->findByGameId(Enchantments::SHARPNESS), 4))
                ->setItem($item)
        );
        $item->addEnchantmentItem(
            (new EnchantmentItem($enchantmentRepository->findByGameId(Enchantments::FIRE_ASPECT), 2))
                ->setItem($item)
        );

        $productRepository->create(new Product(
            $item,
            $categoryRepository->findAll()[1],
            67,
            1
        ));

        $productRepository->create(new Product(
            (new Item(__('seeding.items.diamond_helmet'), \App\Services\Item\Type::ITEM, '310'))
                ->setImage('d2714c56c81bcc4ff35798832226967f.png'),
            $categoryRepository->findAll()[3],
            54,
            1
        ));

        $vipItem = (new Item(__('seeding.items.vip'), \App\Services\Item\Type::PERMGROUP, 'vip'))
            ->setImage('f0c9755f2685d55b7540c941b6f29ff9.png');
        $productRepository->create(new Product(
            $vipItem,
            $categoryRepository->findAll()[2],
            15,
            1
        ));
        $productRepository->create(new Product(
            $vipItem,
            $categoryRepository->findAll()[2],
            100,
            0
        ));
    }
}
