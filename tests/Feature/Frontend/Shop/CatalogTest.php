<?php
declare(strict_types = 1);

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

class CatalogTest extends TestCase
{
    private const PRICE = 1.25;

    private const STACK = 64;

    public function testPurchaseAuthorized(): void
    {
        $this->transaction();
        $this->authAdmin();
        $balance = 100;
        $this->replenishmentUserBalance($balance);
        $product = $this->createProduct();
        $stacks = 2;
        $response = $this->post('/spa/catalog/purchase', [
            'product' => $product->getId(),
            'amount' => self::STACK * $stacks
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment([
            'status' => Status::SUCCESS,
            'quick' => true,
            'newBalance' => $balance - self::PRICE * $stacks
        ]);
        $this->rollback();
    }

    public function testPurchaseAuthorizedNitEnoughMoney(): void
    {
        $this->transaction();
        $this->authAdmin();
        $balance = 1;
        $this->replenishmentUserBalance($balance);
        $product = $this->createProduct();
        $stacks = 2;
        $response = $this->post('/spa/catalog/purchase', [
            'product' => $product->getId(),
            'amount' => self::STACK * $stacks
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment([
            'status' => Status::SUCCESS,
            'quick' => false
        ]);
        $this->rollback();
    }

    public function testPurchaseNotAuthorized(): void
    {
        $this->transaction();
        $product = $this->createProduct();
        $stacks = 1;
        $response = $this->post('/spa/catalog/purchase', [
            'product' => $product->getId(),
            'amount' => self::STACK * $stacks,
            'username' => 'd3lph1'
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment([
            'status' => Status::SUCCESS,
            'quick' => false
        ]);
        $this->rollback();
    }

    public function testPurchaseWithInvalidAmount(): void
    {
        $this->transaction();
        $this->authAdmin();
        $balance = 100;
        $this->replenishmentUserBalance($balance);
        $product = $this->createProduct();
        $response = $this->post('/spa/catalog/purchase', [
            'product' => $product->getId(),
            'amount' => 16 // self::STACK % 16 == 0 - invalid
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->rollback();
    }

    private function replenishmentUserBalance(float $newBalance): void
    {
        $repository = $this->app->make(UserRepository::class);
        $admin = $repository->findByUsername('admin');
        $admin->setBalance($newBalance);
        $repository->update($admin);
    }

    private function createProduct(): Product
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

        $item = new Item('Block of grass', Type::ITEM, '2');
        $this->app->make(ItemRepository::class)
            ->create($item);

        $product = new Product($item, $category, self::PRICE, self::STACK);
        $this->app->make(ProductRepository::class)
            ->create($product);

        return $product;
    }
}
