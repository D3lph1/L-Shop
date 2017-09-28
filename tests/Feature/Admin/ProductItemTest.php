<?php
declare(strict_types = 1);

namespace Tests\Feature\Admin;

use App\DataTransferObjects\Item;
use App\DataTransferObjects\Product;
use App\Models\Item\ItemInterface;
use App\Services\Items\Type;
use App\TransactionScripts\Items;
use App\TransactionScripts\Products;
use Tests\TestCase;

/**
 * Class ProductItemTest
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package Tests\Feature\Admin
 */
class ProductItemTest extends TestCase
{
    /**
     * @var Items
     */
    private $adminItems;

    /**
     * @var Products
     */
    private $adminProduct;

    /**
     * @param null   $name
     * @param array  $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        /** @var Items adminItems */
        $this->adminItems = $this->make(Items::class);

        /** @var Products adminItems */
        $this->adminProduct = $this->make(Products::class);

        parent::__construct($name, $data, $dataName);
    }

    /**
     * Create/delete product/item test
     */
    public function testCase(): void
    {
        $item = $this->adminItems->create(
            (new Item())
                ->setName('Test item')
                ->setType(Type::ITEM)
                ->setImageName(null)
                ->setItem('1337')
                ->setExtra(null)
        );
        $this->assertInstanceOf(ItemInterface::class, $item);
        $itemId = (int)$item->id;
        $dto = (new Product())
            ->setPrice(0.01)
            ->setStack(64)
            ->setItemId($itemId)
            ->setServerId(1)
            ->setCategoryId(1)
            ->setSortPriority(0);

        $product = $this->adminProduct->create($dto);
        $this->assertInstanceOf(Product::class, $product);

        $this->assertTrue($this->adminItems->delete($itemId));
    }
}
