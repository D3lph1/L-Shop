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
     * @var
     */
    private $payment;

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
        $this->payment = (int)$request->route('payment');
        $this->payment = $this->qm->payment($this->payment, ['id', 'cost', 'user_id', 'username', 'complete']);

        // If the payment is completed, deny access
        if ($this->payment->complete) {
            \App::abort(403);
        }

        // If payment with this ID does not exist, exit
        if (!$this->payment) {
            \App::abort(404);
        }

        // Verification of whether the payment the user belongs
        if (is_null($this->payment->username)) {
            if (!is_auth()) {
                // If it is not, deny access
                \App::abort(403);
            }

            if ($this->payment->user_id != \Sentinel::getUser()->getUserId()) {
                // If it is not, deny access
                \App::abort(403);
            }
        }

        $data = [
            'robokassa' => $this->robokassa() ?: null
        ];

        return view('payment.methods', $data);
    }

    public function renderFillUpBalancePage()
    {
        return view('payment.fillupbalance');
    }

    public function fillUpBalance(Request $request)
    {
        $server = (int)$request->route('server');
        $summ = (int)$request->get('summ');

        if ($summ <= 0) {
            return json_response('the summ of negative');
        }

        if ($summ < s_get('payment.fillupbalance.minsumm')) {
            return json_response('summ less min');
        }

        $payment = $this->qm->newPayment(
            null, null, $summ, \Sentinel::getUser()->getUserId(), null, $server, $request->ip(), false
        );

        return json_response('success', ['redirect' => route('payment.cart', [
            'server' => $server,
            'payment' => $payment
        ])]);
    }

    private function robokassa()
    {
        $robokassa = \App::make('payment.robokassa');
        $robokassa
            ->setInvoiceId($this->payment->id)
            ->setSum($this->payment->cost)
            ->setDescription(s_get('shop.name'));

        return $robokassa->getPaymentUrl();
    }
}
