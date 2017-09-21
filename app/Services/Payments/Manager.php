<?php

namespace App\Services\Payments;

use App\Exceptions\InvalidArgumentTypeException;
use App\Exceptions\Payment\InvalidProductsCountException;
use App\Repositories\PaymentRepository;
use App\Repositories\ProductRepository;
use App\Services\Items\Type;

/**
 * Class Manager
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services\Payments
 */
class Manager
{
    const COUNT_TYPE_STACKS = 0;

    const COUNT_TYPE_NUMBER = 1;

    /**
     * @var PaymentRepository
     */
    private $paymentRepository;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var null|int
     */
    private $server = null;

    /**
     * @var null|string
     */
    private $username = null;

    /**
     * @var double Balance of given user.
     */
    private $userBalance;

    /**
     * @var null|string Ip Address the computer from which the payment was created.
     */
    private $ip = null;

    /**
     * @var null|array
     */
    private $products = null;

    /**
     * @var int
     */
    private $productsCountType;

    /**
     * @var int Total cost of this order.
     */
    private $cost = 0;

    /**
     * Manager constructor.
     *
     * @param PaymentRepository $paymentRepository
     * @param ProductRepository $productRepository
     */
    public function __construct(PaymentRepository $paymentRepository, ProductRepository $productRepository)
    {
        $this->paymentRepository = $paymentRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @param array $productsId
     * @param array $productsCount
     * @param int   $productsCountType
     *
     * @return mixed
     *
     */
    public function createPayment(array $productsId, array $productsCount, $productsCountType = self::COUNT_TYPE_STACKS)
    {
        $this->productsCountType = $productsCountType;
        $this->setHandledProductsAndCost($productsId, $productsCount);
        $isQuick = $this->checkOnQuick();
        if ($isQuick) {
            return $this->makeQuick();
        }else {
            return $this->makeNotQuick();
        }
    }

    /**
     * @throws \LogicException
     *
     * @return bool
     */
    private function checkOnQuick()
    {
        if (!is_null($this->username)) {
            return false;
        }

        if (!is_auth()) {
            throw new \LogicException('Username is not set and the user is not authorized');
        }

        $this->username = \Sentinel::getUser()->getUserId();

        return $this->updateBalance();
    }

    /**
     * @return Payment
     */
    private function makeQuick()
    {
        return $this->insert(true);
    }

    /**
     * @return Payment
     */
    private function makeNotQuick()
    {
        return $this->insert(false);
    }

    /**
     * Create new payment in database.
     *
     * @param bool $isQuick
     *
     * @return Payment
     */
    private function insert($isQuick)
    {
        return $this->paymentRepository->create([
            'service' => null,
            'products' => serialize($this->products),
            'cost' => $this->cost,
            'user_id' => is_int($this->username) ? $this->username : null,
            'username' => is_string($this->username) ? $this->username : null,
            'server_id' => $this->server,
            'ip' => $this->ip,
            'completed' => (bool)$isQuick
        ]);
    }

    /**
     * @param array $ids Array with product identifiers.
     * @param array $count Array with product counts.
     *
     * @throws InvalidProductsCountException
     * @throws \LogicException
     */
    private function setHandledProductsAndCost($ids, $count)
    {
        $products = $this->getProducts($ids);
        $idsAndCount = array_combine($ids, $count);
        $result = [];
        $cost = 0;

        foreach ($products as $product) {
            foreach ($idsAndCount as $key => $value) {
                if ($product->id === $key) {
                    if ($value < 0) {
                        throw new InvalidProductsCountException();
                    }

                    // If is item and count is 0
                    if ($product->type === Type::ITEM and $value == 0) {
                        throw new InvalidProductsCountException();
                    }

                    // If it is not permanent privilege but the quantity of goods is 0
                    if ($product->type === Type::PERMGROUP) {
                        if ($product->stack != 0 and $value == 0) {
                            throw new InvalidProductsCountException();
                        }
                    }

                    if ($product->type === Type::PERMGROUP and $product->stack === 0) {
                        $result[$product->id] = 0;
                        $cost += $product->price;

                        continue;
                    }

                    if ($value % $product->stack !== 0) {
                        throw new InvalidProductsCountException();
                    }

                    if ($this->productsCountType === self::COUNT_TYPE_STACKS) {
                        $result[$product->id] = abs($value * $product->stack);
                        $cost += abs($product->price * $value);
                    } else {
                        $result[$product->id] = abs($value);
                        $cost += abs($product->price * ($value / $product->stack));
                    }
                }
            }
        }

        if (!$result) {
            throw new \LogicException('Products referred to arguments not found');
        }

        $this->products = $result;
        $this->cost = round($cost, 2);
    }

    /**
     * Update the user's balance if there are enough funds on his balance sheet.
     *
     * @return bool
     */
    private function updateBalance()
    {
        $this->userBalance = \Sentinel::getUser()->getBalance();
        if ($this->userBalance - $this->cost < 0 ) {
            return false;
        }
        \Sentinel::update(\Sentinel::getUser(), [
            'balance' => $this->userBalance - $this->cost
        ]);

        return true;
    }

    /**
     * Retrieve products with items from database by given identifiers.
     *
     * @param array $ids Array with product identifiers.
     *
     * @return mixed
     */
    private function getProducts($ids)
    {
        return $this->productRepository->getWithItems($ids, [
            'products.id',
            'items.type',
            'products.price',
            'products.stack'
        ]);
    }

    /**
     * @param int $server Server identifier.
     *
     * @throws InvalidArgumentTypeException
     *
     * @return Manager
     */
    public function setServer($server)
    {
        if (!is_int($server)) {
            throw new InvalidArgumentTypeException('integer', $server);
        }
        $this->server = $server;

        return $this;
    }

    /**
     * @param string $username
     *
     * @throws InvalidArgumentTypeException
     *
     * @return Manager
     */
    public function setUsername($username)
    {
        if (!is_string($username)) {
            throw new InvalidArgumentTypeException('string', $username);
        }
        $this->username = $username;

        return $this;
    }

    /**
     * It sets ip address from which the order was made.
     *
     * @param string $ip Ip address.
     *
     * @throws InvalidArgumentTypeException
     *
     * @return Manager
     */
    public function setIp($ip)
    {
        if (!is_string($ip)) {
            throw new InvalidArgumentTypeException('string', $ip);
        }
        $this->ip = $ip;

        return $this;
    }
}
