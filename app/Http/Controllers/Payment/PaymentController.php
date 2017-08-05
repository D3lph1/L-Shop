<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Repositories\PaymentRepository;
use App\Services\Payments\Interkassa\Checkout as InterkassaCheckout;
use App\Services\Payments\Interkassa\Payment as InterkassaPayment;
use App\Services\Payments\Robokassa\Checkout as RobokassaCheckout;
use App\Services\Payments\Robokassa\Payment as RobokassaPayment;
use Illuminate\Http\Request;

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
     * @var Payment
     */
    private $payment;

    /**
     * Render the payment methods page
     *
     * @param Request           $request
     * @param PaymentRepository $paymentRepository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request, PaymentRepository $paymentRepository)
    {
        $this->payment = (int)$request->route('payment');
        $this->payment = $paymentRepository->find($this->payment, ['id', 'cost', 'user_id', 'username', 'completed']);

        // If payment with this ID does not exist, exit.
        if (!$this->payment) {
            $this->app->abort(404);
        }

        // If the payment is completed, deny access.
        if ($this->payment->completed) {
            $this->app->abort(403);
        }

        // Verification of whether the payment the user belongs.
        if (is_null($this->payment->username)) {
            if (!is_auth()) {
                // If it is not, deny access.
                $this->app->abort(403);
            }

            if ($this->payment->user_id != $this->sentinel->getUser()->getUserId()) {
                // If it is not, deny access.
                $this->app->abort(403);
            }
        }

        $data = [
            'robokassa' => $this->robokassa(),
            'interkassa' => $this->interkassa(),
        ];

        return view('payment.methods', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function renderFillUpBalancePage()
    {
        return view('payment.fillupbalance');
    }

    /**
     * @param Request           $request
     * @param PaymentRepository $paymentRepository
     *
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function fillUpBalance(Request $request, PaymentRepository $paymentRepository)
    {
        $server = (int)$request->route('server');
        $sum = abs($request->get('sum'));

        $validated = $this->validateFillUpBalanceSum($sum, true);
        if ($validated !== true) {
            return $validated;
        }

        $payment = $paymentRepository->create([
            'service' => null,
            'products' => null,
            'cost' => $sum,
            'user_id' => $this->sentinel->getUser()->getUserId(),
            'username' => null,
            'server_id' => $server,
            'ip' => $request->ip(),
            'completed' => false
        ]);

        return json_response('success',[
                'redirect' => route('payment.methods', [
                'server' => $server,
                'payment' => $payment
            ])
        ]);
    }

    /**
     * @return string
     */
    private function robokassa()
    {
        if (!s_get('payment.method.robokassa.enabled')) {
            return null;
        }

        /** @var RobokassaCheckout $checkout */
        $checkout = $this->app->make(RobokassaCheckout::class);
        $payment = new RobokassaPayment($this->payment->id, $this->payment->cost);
        $payment->setDescription(s_get('shop.name'));

        return $checkout->getPaymentUrl($payment);
    }

    /**
     * @return string
     */
    private function interkassa()
    {
        if (!s_get('payment.method.interkassa.enabled')) {
            return null;
        }

        /** @var InterkassaCheckout $checkout */
        $checkout = $this->app->make(InterkassaCheckout::class);
        $payment = new InterkassaPayment($this->payment->id, $this->payment->cost);
        $payment->setDescription(s_get('shop.name'));
        $payment->setCurrency(s_get('payment.method.interkassa.currency'));

        return $checkout->getPaymentUrl($payment);
    }
}
