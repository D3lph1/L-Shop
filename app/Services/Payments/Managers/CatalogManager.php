<?php

namespace App\Services\Payments\Managers;

use App\Services\Payments\Manager;
use Illuminate\Http\Request;

/**
 * Class BuyManager
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services\Payments\Managers
 */
class CatalogManager extends Manager
{
    /**
     * @param Request $request
     *
     * @return array|bool|\Illuminate\Http\JsonResponse
     */
    public function handle(Request $request)
    {
        $this->server = $request->route('server');

        $result = $this->buildPayment($request);
        if (!is_array($result)) {
            return $result;
        }

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
     * @param Request $request
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    private function buildPayment(Request $request)
    {
        $product = null;
        $user = null;
        $cost = null;

        try {
            $user = $this->getUsernameOrId($request->get('username'));
            $productsAndCost = $this->getProductAndCost($request->get('product'), $request->get('count'));
            $product = $productsAndCost['product'];
            $cost = $productsAndCost['cost'];
        } catch (\UnexpectedValueException $e) {
            return json_response($e->getMessage());
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
                        $this->qm->newPayment(null, $product, $cost, $user_id, null, $this->server, $request->ip(), true)
                ];
            }
        } else {
            // If user is not auth
            $username = $user;
        }

        return [
            'quick' => false,   // A sign that the payment is not a "quick"

            'result' => // Stores payment identifier in the case of successful query
                $this->qm->newPayment(null, $product, $cost, $user_id, $username, $this->server, $request->ip())
        ];
    }

    /**
     * @param int|string $product
     * @param int|string $count
     *
     * @return array
     */
    private function getProductAndCost($product, $count)
    {
        $product = $this->qm->product($product);
        if ($product->isEmpty()) {
            throw new \UnexpectedValueException('invalid item id');
        }

        $product= $product[0];
        if ($count % $product->stack !== 0) {
            throw new \UnexpectedValueException('invalid items count');
        }
        $count = $count / $product->stack;

        return [
            'product' => serialize([$product->id => $count]),
            'cost' => $product->price * $count
        ];
    }
}
