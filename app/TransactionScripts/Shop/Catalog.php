<?php
declare(strict_types = 1);

namespace App\TransactionScripts\Shop;

use App\Exceptions\Category\NotFoundException;
use App\Exceptions\User\InvalidUsernameException;
use App\Models\Category\CategoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Server\ServerRepositoryInterface;
use App\Services\Distributors\Distributor;
use App\Services\Payments\Manager;
use App\Traits\BuyResponse;
use App\Traits\ContainerTrait;
use App\Traits\Validator;

class Catalog
{
    use ContainerTrait;

    use Validator;

    use BuyResponse;

    public function categories(int $serverId): iterable
    {
        return $this->make(ServerRepositoryInterface::class)
            ->categories($serverId, ['id', 'name', 'server_id']);
    }

    public function currentCategory(int $currentCategoryId, iterable $categories): CategoryInterface
    {
        $category = $currentCategoryId;
        $flag = false;

        /** @var CategoryInterface $one */
        foreach ($categories as $one) {
            if ($category === 0) {
                $category = $one;
                $flag = true;
                break;
            }
            if ($category === $one->getId()) {
                $category = $one;
                $flag = true;
                break;
            }
        }

        // If a category with this ID does not exist.
        if (!$flag) {
            throw new NotFoundException($category);
        }

        return $category;
    }

    public function products(int $serverId, int $categoryId)
    {
        /** @var ProductRepositoryInterface $repository */
        $repository = $this->make(ProductRepositoryInterface::class);

        return $repository->forCatalog(
            $serverId,
            $categoryId,
            ['products.id', 'products.price', 'products.stack', 'products.sort_priority'],
            ['items.name', 'items.type', 'items.item', 'items.image']
        );
    }

    public function purchase(int $productId, float $count, int $server, string $ip, ?string $username)
    {
        $productId = [$productId];
        $productCount = [$count];

        /** @var Manager $manager */
        $manager = $this->make('payment.manager');
        $manager
            ->setServer($server)
            ->setIp($ip);

        $this->username($username);

        if (!is_auth() and $username) {
            $manager->setUsername($username);
        }

        $payment = null;
        \DB::transaction(function () use ($manager, $productId, $productCount, &$payment) {
            $payment = $manager->createPayment($productId, $productCount, Manager::COUNT_TYPE_NUMBER);
            if ($payment->completed) {
                /** @var Distributor $distributor */
                $distributor = $this->make('distributor');
                $distributor->give($payment);
            }
        });

        return $this->buildResponse($server, $payment);
    }

    private function username(?string $username): void
    {
        if (!is_auth()) {
            $validated = $this->validateUsername($username, false);
            if (!$validated) {
                throw new InvalidUsernameException();
            }
        }
    }
}
