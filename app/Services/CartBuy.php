<?php

namespace App\Services;

use App\Exceptions\User\InvalidUsernameException;
use App\Services\Distributors\Distributor;
use App\Services\Payments\Manager;
use App\Traits\BuyResponse;
use App\Traits\Validator;

/**
 * Class CartBuy
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services
 */
class CartBuy
{
    use BuyResponse;

    use Validator;

    /**
     * @var Manager
     */
    private $manager;

    /**
     * @var Distributor
     */
    private $distributor;

    /**
     * @var array
     */
    private $productsId = [];

    /**
     * @var array
     */
    private $productsCount = [];

    public function __construct()
    {
        $this->manager = \App::make('payment.manager');
        $this->distributor = \App::make('distributor');
    }

    /**
     * Method - handler
     *
     * @param array       $products
     * @param Cart        $cart
     * @param int         $server
     * @param string      $ip
     * @param null|string $username
     *
     * @throws InvalidUsernameException
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function buy(array $products, Cart $cart, $server, $ip, $username = null)
    {
        $this->setProductsIdAndCount($products);
        $this->manager
            ->setServer($server)
            ->setIp($ip);

        $this->username($username);

        if (!is_auth() and $username) {
            $this->manager->setUsername($username);
        }

        $payment = null;
        \DB::transaction(function () use ($cart, &$payment) {
            $payment = $this->manager->createPayment($this->productsId, $this->productsCount, Manager::COUNT_TYPE_NUMBER);
            if ($payment->completed) {
                $this->distributor->give($payment);
            }
            $cart->flush();
        });

        return $this->buildResponse($server, $payment);
    }

    /**
     * Convert products adn costs in needed format
     *
     * @param array $products
     */
    private function setProductsIdAndCount($products)
    {
        foreach ($products as $product) {
            $this->productsId[] = $product['id'];
            $this->productsCount[] = isset($product['count']) ? $product['count'] : 0;
        }
    }

    /**
     * Validate username
     *
     * @param null $username
     *
     * @throws InvalidUsernameException
     */
    private function username($username = null)
    {
        if (!is_auth()) {
            $validated = $this->validateUsername($username, false);
            if ($validated !== true) {
                throw new InvalidUsernameException();
            }
        }
    }
}
