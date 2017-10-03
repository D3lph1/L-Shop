<?php
declare(strict_types = 1);

namespace App\TransactionScripts\Shop;

use App\Exceptions\User\InvalidUsernameException;
use App\Models\Product\ProductInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\Distributors\Distributor;
use App\Services\Payments\Manager;
use App\Traits\BuyResponse;
use App\Traits\ContainerTrait;
use App\Traits\Validator;
use Illuminate\Support\Facades\DB;

/**
 * Class Cart
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\TransactionScripts\Shop
 */
class Cart
{
    use ContainerTrait;

    use Validator;

    use BuyResponse;

    public function products(): iterable
    {
        /** @var ProductRepositoryInterface $repository */
        $repository = $this->make(ProductRepositoryInterface::class);
        /** @var \App\Services\Cart $cart */
        $cart = $this->make(\App\Services\Cart::class);
        $fromCart = $cart->products();
        $identifiers = array_keys($fromCart);
        $products = [];

        if (count($identifiers) > 0) {
            $products = $repository->withItemsMultiple(
                $identifiers,
                ['products.id', 'products.price', 'products.stack'],
                ['items.name', 'items.type', 'items.image']);
        }

        return $products;
    }

    public function cost(iterable $products): float
    {
        $cost = 0;
        /** @var ProductInterface $product */
        foreach ($products as $product) {
            $cost += $product->getPrice();
        }

        return $cost;
    }

    public function purchase(array $products, int $server, string $ip, ?string $username)
    {
        $productsId = [];
        $productsCount = [];

        foreach ($products as $product) {
            $productsId[] = $product['id'];
            $productsCount[] = isset($product['count']) ? $product['count'] : 0;
        }

        /** @var Manager $manager */
        $manager = $this->make(Manager::class);
        $manager
            ->setServer($server)
            ->setIp($ip);

        $this->username($username);

        if (!is_auth() and $username) {
            $manager->setUsername($username);
        }

        $payment = null;
        DB::transaction(function () use (&$payment, $productsId, $productsCount, $manager) {
            $payment = $manager->createPayment($productsId, $productsCount, Manager::COUNT_TYPE_NUMBER);
            if ($payment->completed) {
                /** @var Distributor $distributor */
                $distributor = $this->make('distributor');
                $distributor->give($payment);
            }

            $cart = $this->make(\App\Services\Cart::class);
            $cart->flush();
        });

        return $this->buildResponse($server, $payment);
    }

    /**
     * Validate username
     */
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
