<?php
declare(strict_types=1);

namespace Tests\Feature\Frontend\Shop;

use App\Entity\Category;
use App\Entity\Item;
use App\Entity\Product;
use App\Entity\Server;
use App\Repository\Item\ItemRepository;
use App\Repository\Product\ProductRepository;
use App\Repository\Server\ServerRepository;
use App\Repository\User\UserRepository;
use App\Services\Item\Type;
use App\Services\Purchasing\Distributors\Pool;
use App\Services\Response\Status;
use Illuminate\Http\Response;
use Tests\TestCase;

class CartTest extends TestCase
{
    private const ITEM_PRICE = 1.25;

    private const ITEM_STACK = 64;

    private const PERMGROUP_PRICE = 17;

    private const PERMGROUP_DURATION = 30;

    private const PERMGROUP_FOREVER_PRICE = 100;

    private const CURRENCY_PRICE = 125;

    private const CURRENCY_STACK = 25;

    private const REGION_OWNER_PRICE = 37;

    private const REGION_MEMBER_PRICE = 32;

    private const COMMAND_PRICE = 81;

    public function testPurchaseAuthorized(): void
    {
        $this->transaction();
        $this->authAdmin();
        $balance = 1000;
        $this->replenishmentUserBalance($balance);
        $category = $this->createCategory();
        $productItem = $this->createProductItem($category);
        $productPermgroup = $this->createProductPermgroup($category);
        $productPermgroupForever = $this->createProductPermgroupForever($category);
        $productCurrency = $this->createProductCurrency($category);
        $productRegionOwner = $this->createProductRegionOwner($category);
        $productRegionMember = $this->createProductRegionMember($category);
        $productCommand = $this->createProductCommand($category);

        $this->putInCart($productItem);
        $this->putInCart($productPermgroup);
        $this->putInCart($productPermgroupForever);
        $this->putInCart($productCurrency);
        $this->putInCart($productRegionOwner);
        $this->putInCart($productRegionMember);
        $this->putInCart($productCommand);

        $productItemStackMultiplier = 2;
        $productPermgroupDurationMultiplier = 4;
        $productCurrencyStackMultiplier = 1;

        $items = [
            $productItem->getId() => $productItem->getStack() * $productItemStackMultiplier,
            $productPermgroup->getId() => $productPermgroup->getStack() * $productPermgroupDurationMultiplier,
            $productPermgroupForever->getId() => 0,
            $productCurrency->getId() => $productCurrency->getStack() * $productCurrencyStackMultiplier,
            $productRegionOwner->getId() => 0,
            $productRegionMember->getId() => 0,
            $productCommand->getId() => 0,
        ];

        $expectedBalance = $balance - (
                $productItem->getPrice() * $productItemStackMultiplier +
                $productPermgroup->getPrice() * $productPermgroupDurationMultiplier +
                $productPermgroupForever->getPrice() +
                $productCurrency->getPrice() * $productCurrencyStackMultiplier +
                $productRegionOwner->getPrice() +
                $productRegionMember->getPrice() +
                $productCommand->getPrice()
            );

        $response = $this->post("/spa/cart/{$category->getServer()->getId()}", [
            'items' => $items
        ]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment([
            'status' => Status::SUCCESS,
            'quick' => true,
            'newBalance' => $expectedBalance
        ]);

        $this->rollback();
    }

    private function putInCart(Product $product): void
    {
        $response = $this->put('/spa/cart', [
            'product' => $product->getId()
        ]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment([
            'status' => Status::SUCCESS
        ]);
    }

    private function createCategory(): Category
    {
        $this->app->bind(Pool::class, function () {
            return new Pool([
                new MockDistributor()
            ]);
        });

        $server = new Server('Vanilla', MockDistributor::class);
        $category = new Category('Blocks', $server);
        $server->getCategories()->add($category);
        $this->app->make(ServerRepository::class)->create($server);

        return $category;
    }

    private function createProductItem(Category $category): Product
    {
        $item = new Item('Block of grass', Type::ITEM, '2');
        $this->app->make(ItemRepository::class)
            ->create($item);

        $product = new Product($item, $category, self::ITEM_PRICE, self::ITEM_STACK);
        $this->app->make(ProductRepository::class)
            ->create($product);

        return $product;
    }

    private function createProductPermgroup(Category $category): Product
    {
        $item = new Item('VIP', Type::PERMGROUP, 'vip');
        $this->app->make(ItemRepository::class)
            ->create($item);

        $product = new Product($item, $category, self::PERMGROUP_PRICE, self::PERMGROUP_DURATION);
        $this->app->make(ProductRepository::class)
            ->create($product);

        return $product;
    }

    private function createProductPermgroupForever(Category $category): Product
    {
        $item = new Item('VIP forever', Type::PERMGROUP, 'vip');
        $this->app->make(ItemRepository::class)
            ->create($item);

        $product = new Product($item, $category, self::PERMGROUP_FOREVER_PRICE, 0);
        $this->app->make(ProductRepository::class)
            ->create($product);

        return $product;
    }

    private function createProductCurrency(Category $category): Product
    {
        $item = new Item('Credits', Type::CURRENCY, null);
        $this->app->make(ItemRepository::class)
            ->create($item);

        $product = new Product($item, $category, self::CURRENCY_PRICE, self::CURRENCY_STACK);
        $this->app->make(ProductRepository::class)
            ->create($product);

        return $product;
    }

    private function createProductRegionOwner(Category $category): Product
    {
        $item = new Item('Region (owner)', Type::REGION_OWNER, 'region_name');
        $this->app->make(ItemRepository::class)
            ->create($item);

        $product = new Product($item, $category, self::REGION_OWNER_PRICE, 0);
        $this->app->make(ProductRepository::class)
            ->create($product);

        return $product;
    }

    private function createProductRegionMember(Category $category): Product
    {
        $item = new Item('Region (member)', Type::REGION_MEMBER, 'region_name');
        $this->app->make(ItemRepository::class)
            ->create($item);

        $product = new Product($item, $category, self::REGION_MEMBER_PRICE, 0);
        $this->app->make(ProductRepository::class)
            ->create($product);

        return $product;
    }

    private function createProductCommand(Category $category): Product
    {
        $item = new Item('Executable command', Type::COMMAND, 'do something');
        $this->app->make(ItemRepository::class)
            ->create($item);

        $product = new Product($item, $category, self::COMMAND_PRICE, 0);
        $this->app->make(ProductRepository::class)
            ->create($product);

        return $product;
    }

    private function replenishmentUserBalance(float $newBalance): void
    {
        $repository = $this->app->make(UserRepository::class);
        $admin = $repository->findByUsername('admin');
        $admin->setBalance($newBalance);
        $repository->update($admin);
    }
}
