<?php

namespace App\Services\Payments;

use App\Services\Cart;
use App\Services\QueryManager;

/**
 * Class Manager
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services\Payments
 */
abstract class Manager
{
    /**
     * Server id
     *
     * @var int
     */
    protected $server;

    /**
     * @var QueryManager
     */
    protected $qm;

    /**
     * @var Cart
     */
    protected $cart;

    /**
     * @param QueryManager $qm
     * @param Cart         $cart
     */
    public function __construct(QueryManager $qm, Cart $cart)
    {
        $this->qm = $qm;
        $this->cart = $cart;
    }

    /**
     * Return the username or ID, depending on whether there is a payment from an authorized user or not
     *
     * @param $username
     *
     * @return int|string
     */
    protected function getUsernameOrId($username)
    {
        if (is_auth()) {
            return (int)\Sentinel::getUser()->getUserId();
        }

        // If user not auth
        if (mb_strlen($username) > 3) {
            return (string)$username;
        }

        throw new \UnexpectedValueException('invalid username');
    }

    /**
     * @param $result
     *
     * @return bool|\Illuminate\Http\JsonResponse
     */
    protected function makeQuick($result)
    {
        if (is_int($result['result'])) {
            // Clear the cart
            $this->cart->clear($this->server);

            return json_response(
                'success',
                [
                    'quick' => true,    // A sign that the payment is a "quick"
                    'new_balance' => \Sentinel::getUser()->getBalance()     // New user balance for replace old balance by JavaScript
                ]
            );
        }

        return false;
    }

    /**
     * @param $result
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function makeNotQuick($result)
    {
        // Clear the cart
        $this->cart->clear($this->server);
        $message = \App::make('msg')->info('На вашем счету недостаточно средств для совершения покупки.
                Вы можете оплатить покупку любым удобным для вас способом прямо сейчас.');

        return json_response(
            'success',
            [
                'quick' => false,   // A sign that the payment is not a "quick"
                // Redirect link
                'redirect' => route('payment.cart', [
                    'server' => $this->server,
                    'payment' => $result['result']
                ])
            ]
        )->withCookie($message);
    }

    public function refillBalance()
    {
        //
    }

    public function quickPay()
    {
        //
    }
}
