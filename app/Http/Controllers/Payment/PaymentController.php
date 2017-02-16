<?php

namespace App\Http\Controllers\Payment;

use App\Services\Cart;
use App\Services\QueryManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class PaymentController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Payment
 */
class PaymentController extends Controller
{
    /**
     * Server id
     *
     * @var int
     */
    private $server;

    /**
     * @var Cart
     */
    private $cart;

    /**
     * @var QueryManager
     */
    private $qm;

    /**
     * @param Cart         $cart
     * @param QueryManager $qm
     */
    public function __construct(Cart $cart, QueryManager $qm)
    {
        $this->cart = $cart;
        $this->qm = $qm;
    }

    /**
     * Render the payment methods page
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        $this->server = (int)$request->route('server');
        $this->username = $request->get('username');

        $data = [
            'robokassa' => $this->robokassa() ?: null
        ];

        return view('payment.methods', $data);
    }

    private function robokassa()
    {

    }
}
