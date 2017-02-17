<?php

namespace App\Services\Payments\Managers;

use App\Services\Payments\Manager;
use Illuminate\Http\Request;

/**
 * Class CartManager
 *
 * Execution of payment, when the user presses the corresponding button on the cart page.
 * Notice:
 *      In the context of the this class is called the "quick" delivery of such payment,
 *      which is produced when the user has enough money on the balance sheet and
 *      "not quick" one that leads to redirect the user to select a payment
 *      aggregator page to make a payment.
 *
 * @package App\Services\Payments\Managers
 */
class CartManager extends Manager
{
    /**
     * @param Request $request
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function handle(Request $request)
    {
        $this->server = $request->route('server');
        $result = $this->buildPayment($request);

        if ($result['quick']) {
            // If the user has enough money in the account to make quick payment
            $result = $this->makeQuick($result);
            if ($result !== false) {
                return $result;
            }
        }

        // If the user does not have enough money in the account, redirect it to the page select a payment aggregator
        if (is_int($result['result'])) {
            return $this->makeNotQuick($result);
        }

        return json_response('failed');
    }

    /**
     * Collect data for create new payment
     *
     * @param Request $request
     *
     * @return array
     */
    private function buildPayment(Request $request)
    {
        $productsAndCost = $this->getProductsAndCost();
        $products = $productsAndCost['products'];
        $cost = $productsAndCost['cost'];

        try {
            $user = $this->getUsernameOrId($request->get('username'));
        } catch (\UnexpectedValueException $e) {
            return json_response('invalid username');
        }

        $user_id = null;
        $username = null;

        // If user is auth
        if (is_int($user)) {
            $user_id = $user;
            $balance = \Sentinel::getUser()->getBalance() - $cost;
            // If the user has enough money in the account to make quick payment
            if ($balance >= 0) {
                // Update user balance
                \Sentinel::update(\Sentinel::getUser(), [
                    'balance' => $balance
                ]);

                return [
                    'quick' => true,    // A sign that the payment is a "quick"

                    'result' => // Stores payment identifier in the case of successful query
                        $this->qm->newPayment(null, $products, $cost, $user_id, null, $this->server, $request->ip(), true)
                ];
            }
        } else {
            // If user is not auth
            $username = $user;
        }

        return [
            'quick' => false,   // A sign that the payment is not a "quick"

            'result' => // Stores payment identifier in the case of successful query
                $this->qm->newPayment(null, $products, $cost, $user_id, $username, $this->server, $request->ip())
        ];
    }

    /**
     * Get products data [id => count] (in serialized form) and total products cost for payment
     *
     * @return array
     */
    private function getProductsAndCost()
    {
        $cost = 0;
        $storage = [];
        $fromCart = $this->cart->getAll($this->server);
        foreach ($fromCart as $key => $value) {
            $product = $this->qm->product($key)[0];
            $storage[$key] = $this->cart->getCount($this->server, $key);
            $cost += $product->price * $storage[$key];
        }

        return [
            'products' => serialize($storage),
            'cost' => $cost
        ];
    }

    /**
     * Return the username or ID, depending on whether there is a payment from an authorized user or not
     *
     * @param $username
     *
     * @return int|string
     */
    private function getUsernameOrId($username)
    {
        if (is_auth()) {
            return (int)\Sentinel::getUser()->getUserId();
        }

        // If user not auth
        if (mb_strlen($username) > 3) {
            return (string)$username;
        }

        throw new \UnexpectedValueException('username is short');
    }

    /**
     * @param $result
     *
     * @return bool|\Illuminate\Http\JsonResponse
     */
    private function makeQuick($result)
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
    private function makeNotQuick($result)
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
}
