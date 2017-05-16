<?php

namespace App\Services\Payments;

use App\Exceptions\Payment\InvalidProductsCountException;
use App\Models\Payment;
use App\Services\QueryManager;
use App\Exceptions\LShopException;
use App\Exceptions\InvalidArgumentTypeException;

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
     * @var QueryManager
     */
    private $qm;

    /**
     * @var null|int
     */
    private $server = null;

    /**
     * @var null|string
     */
    private $username = null;

    /**
     * @var double
     */
    private $userBalance;

    /**
     * Ip Address the computer from which the payment was created
     *
     * @var null|string
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
     * @var int
     */
    private $cost = 0;

    /**
     * @param QueryManager $qm
     */
    public function __construct(QueryManager $qm)
    {
        $this->qm = $qm;
    }

    /**
     * @param array $productsId
     * @param array $productsCount
     *
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
     * @return bool
     * @throws LShopException
     */
    private function checkOnQuick()
    {
        if (!is_null($this->username)) {
            return false;
        }

        if (!is_auth()) {
            throw new LShopException('Username is not set and the user is not authorized');
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
     * @param bool $isQuick
     *
     * @return Payment
     */
    private function insert($isQuick)
    {
        return $this->qm->createPayment(
            null,
            serialize($this->products),
            $this->cost,
            is_int($this->username) ? $this->username : null,
            is_string($this->username) ? $this->username : null,
            $this->server,
            $this->ip,
            $isQuick
        );
    }

    /**
     * @param array $ids Array with product identifiers
     * @param array $count Array with product counts
     *
     * @throws InvalidProductsCountException
     * @throws LShopException
     */
    private function setHandledProductsAndCost($ids, $count)
    {
        $products = $this->getProducts($ids);
        $idsAndCount = array_combine($ids, $count);
        $result = [];
        $cost = 0;

        foreach ($products as $product) {
            foreach ($idsAndCount as $key => $value) {
                if ($value < 0) {
                    throw new InvalidProductsCountException();
                }

                // If is item and count is 0
                if ($product->type === 'item' and $value == 0) {
                    throw new InvalidProductsCountException();
                }

                // If it is not permanent privilege but the quantity of goods is 0
                if ($product->type === 'permgroup') {
                    if ($product->stack != 0 and $value == 0) {
                        throw new InvalidProductsCountException();
                    }
                }

                if ($product->id == $key) {
                    if ($product->type === 'permgroup' and $product->stack === 0) {
                        $result[$product->id] = 0;
                        $cost += $product->price;

                        continue;
                    }

                    if ($value % $product->stack !== 0) {
                        throw new InvalidProductsCountException();
                    }

                    if ($this->productsCountType == self::COUNT_TYPE_STACKS) {
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
            throw new LShopException('Products referred to arguments not found');
        }

        $this->products = $result;
        $this->cost = round($cost, 2);
    }

    /**
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
     * @param array $ids Array with product identifiers
     *
     * @return mixed
     */
    private function getProducts($ids)
    {
        return $this->qm->product($ids, [
            'products.id',
            'items.type',
            'products.price',
            'products.stack'
        ], true);
    }

    /**
     * @param int $server
     *
     * @return Manager
     * @throws InvalidArgumentTypeException
     */
    public function setServer($server)
    {
        if (!is_int($server)) {
            throw new InvalidArgumentTypeException('string', $server);
        }
        $this->server = $server;

        return $this;
    }

    /**
     * @param string $username
     *
     * @return Manager
     * @throws InvalidArgumentTypeException
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
     * @param string $ip
     *
     * @return Manager
     * @throws InvalidArgumentTypeException
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
