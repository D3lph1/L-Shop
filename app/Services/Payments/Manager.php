<?php
declare(strict_types = 1);

namespace App\Services\Payments;

use App\DataTransferObjects\Payment;
use App\Exceptions\InvalidArgumentTypeException;
use App\Exceptions\LogicException;
use App\Exceptions\Payment\InvalidProductsCountException;
use App\Models\Payment\PaymentInterface;
use App\Models\Product\ProductInterface;
use App\Repositories\Payment\PaymentRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\Items\Type;
use App\Services\User\Balance;
use App\Traits\ContainerTrait;
use Cartalyst\Sentinel\Sentinel;

/**
 * Class Manager
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Services\Payments
 */
class Manager
{
    use ContainerTrait;

    const COUNT_TYPE_STACKS = 0;

    const COUNT_TYPE_NUMBER = 1;

    /**
     * @var PaymentRepositoryInterface
     */
    private $paymentRepository;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var Sentinel
     */
    private $sentinel;

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
     */
    public function __construct(
        PaymentRepositoryInterface $paymentRepository,
        ProductRepositoryInterface $productRepository,
        Sentinel $sentinel)
    {
        $this->paymentRepository = $paymentRepository;
        $this->productRepository = $productRepository;
        $this->sentinel = $sentinel;
    }

    /**
     * @param array $productsId
     * @param array $productsCount
     * @param int   $productsCountType
     *
     * @return mixed
     *
     */
    public function createPayment(array $productsId, array $productsCount, int $productsCountType = self::COUNT_TYPE_STACKS)
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
     * @throws LogicException
     */
    private function checkOnQuick(): bool
    {
        if (!is_null($this->username)) {
            return false;
        }

        if (!is_auth()) {
            throw new LogicException('Username is not set and the user is not authorized');
        }

        $this->username = $this->sentinel->getUser()->getId();

        return $this->updateBalance();
    }

    private function makeQuick(): PaymentInterface
    {
        return $this->insert(true);
    }

    private function makeNotQuick(): PaymentInterface
    {
        return $this->insert(false);
    }

    /**
     * Create new payment in database.
     */
    private function insert(bool $isQuick): PaymentInterface
    {
        /** @var PaymentInterface $entity */
        $entity = $this->make(PaymentInterface::class);

        return $this->paymentRepository->create(
            $entity
                ->setProducts($this->products)
                ->setCost($this->cost)
                ->setUserId(is_int($this->username) ? $this->username : null)
                ->setServerId($this->server)
                ->setIp($this->ip)
                ->setCompleted($isQuick)
        );
    }

    /**
     * @param array $ids Array with product identifiers.
     * @param array $count Array with product counts.
     *
     * @throws InvalidProductsCountException
     * @throws LogicException
     */
    private function setHandledProductsAndCost(array $ids, array $count): void
    {
        $products = $this->getProducts($ids);
        $idsAndCount = array_combine($ids, $count);
        $result = [];
        $cost = 0;

        /** @var ProductInterface $product */
        foreach ($products as $product) {
            foreach ($idsAndCount as $key => $value) {
                if ($product->getId() === $key) {
                    if ($value < 0) {
                        throw new InvalidProductsCountException();
                    }

                    // If is item and count is 0
                    if ($product->getItem()->getType() === Type::ITEM and $value == 0) {
                        throw new InvalidProductsCountException();
                    }

                    // If it is not permanent privilege but the quantity of goods is 0
                    if ($product->getItem()->getType() === Type::PERMGROUP) {
                        if ($product->getStack() != 0 and $value == 0) {
                            throw new InvalidProductsCountException();
                        }
                    }

                    if ($product->getItem()->getType() === Type::PERMGROUP and $product->getStack() == 0) {
                        $result[$product->getId()] = 0;
                        $cost += $product->getPrice();

                        continue;
                    }

                    if ($value % $product->getStack() !== 0) {
                        throw new InvalidProductsCountException();
                    }

                    if ($this->productsCountType === self::COUNT_TYPE_STACKS) {
                        $result[$product->getId()] = abs($value * $product->getStack());
                        $cost += abs($product->getPrice() * $value);
                    } else {
                        $result[$product->getId()] = abs($value);
                        $cost += abs($product->getPrice() * ($value / $product->getStack()));
                    }
                }
            }
        }

        if (!$result) {
            throw new LogicException('Products referred to arguments not found');
        }

        $this->products = $result;
        $this->cost = round($cost, 2);
    }

    /**
     * Update the user's balance if there are enough funds on his balance sheet.
     */
    private function updateBalance(): bool
    {
        $this->userBalance = $this->sentinel->getUser()->getBalance();
        if ($this->userBalance - $this->cost < 0 ) {
            return false;
        }
        Balance::sub(\Sentinel::getUser(), $this->cost);

        return true;
    }

    /**
     * Retrieve products with items from database by given identifiers.
     */
    private function getProducts(array $ids): iterable
    {
        return $this->productRepository->withItemsMultiple(
            $ids,
            ['id', 'price', 'stack'],
            ['type']
        );
    }

    public function setServer(int $server): self
    {
        $this->server = $server;

        return $this;
    }

    public function setUsername(string $username): self
    {
        if (!is_string($username)) {
            throw new InvalidArgumentTypeException('string', $username);
        }
        $this->username = $username;

        return $this;
    }

    /**
     * It sets ip address from which the order was made.
     */
    public function setIp(string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }
}
