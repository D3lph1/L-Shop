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
 * @author  D3lph1 <d3lph1.contact@gmail.com>
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
                $this->qm->newPayment(null, $products, $cost, $user_id, $username, $this->server, $request->ip(), false)
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
        $ids = array_keys($fromCart);
        $products = $this->qm->product(
            $ids,
            ['products.id as id', 'items.name', 'items.image', 'products.price', 'products.stack']
        );
        foreach ($fromCart as $key => $value) {
            foreach ($products as $product) {
                if ($key == $product->id) {
                    $storage[$key] = $this->cart->getCount($this->server, $key);
                    $cost += $product->price * $storage[$key];
                }
            }
        }

        return [
            'products' => serialize($storage),
            'cost' => $cost
        ];
    }
}
