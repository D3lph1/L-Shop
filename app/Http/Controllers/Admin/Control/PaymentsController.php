<?php

namespace App\Http\Controllers\Admin\Control;

use App\Http\Requests\Admin\SavePaymentsRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class PaymentsController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\Control
 */
class PaymentsController extends Controller
{
    /**
     * Available hash algos for robokassa.
     *
     * @var array
     */
    private $robokassaAlgos = [
        'md5',
        'ripemd160',
        'sha1',
        'sha256',
        'sha384',
        'sha512'
    ];

    private $interkassaAlgos = [
        'md5',
        'sha256'
    ];

    /**
     * Render payments settings page.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        $data = [
            'currentServer' => $request->get('currentServer'),
            'minSum' => s_get('payment.fillupbalance.minsum'),
            'currency' => s_get('shop.currency'),
            'currencyHtml' => s_get('shop.currency_html'),

            'robokassaEnable' => s_get('payment.method.robokassa.enabled'),
            'robokassaLogin' => s_get('payment.method.robokassa.login'),
            'robokassaPassword1' => s_get('payment.method.robokassa.password1'),
            'robokassaPassword2' => s_get('payment.method.robokassa.password2'),
            'robokassaAlgo' => s_get('payment.method.robokassa.algo'),
            'robokassaIsTest' => (bool)s_get('payment.method.robokassa.test'),
            'robokassaAlgos' => $this->robokassaAlgos,

            'interkassaEnable' => s_get('payment.method.interkassa.enabled'),
            'interkassaLogin' => s_get('payment.method.interkassa.checkout_id'),
            'interkassaKey' => s_get('payment.method.interkassa.key'),
            'interkassaTestKey' => s_get('payment.method.interkassa.test_key'),
            'interkassaAlgo' => s_get('payment.method.interkassa.algo'),
            'interkassaIsTest' => (bool)s_get('payment.method.interkassa.test'),
            'interkassaCurrency' => s_get('payment.method.interkassa.currency'),

            'interkassaAlgos' => $this->interkassaAlgos,
        ];

        return view('admin.control.payments', $data);
    }

    /**
     * Handle the save payments settings request.
     *
     * @param SavePaymentsRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SavePaymentsRequest $request)
    {
        $this->all($request);

        try {
            $this->robokassa($request);
        } catch (\UnexpectedValueException $e) {
            $this->msg->danger(__('messages.admin.control.payments.robokassa.unknowns_algo'));

            return back();
        }

        try {
            $this->interkassa($request);
        } catch (\UnexpectedValueException $e) {
            $this->msg->danger(__('messages.admin.control.payments.interkassa.unknowns_algo'));

            return back();
        }

        $this->msg->success(__('messages.admin.changes_saved'));

        return back();
    }

    /**
     * Save all settings.
     *
     * @param Request $request
     */
    private function all(Request $request)
    {
        s_set('payment.fillupbalance.minsum', $request->get('min_sum'));
        s_save();
    }

    /**
     * Save settings for robokassa.
     *
     * @param Request $request
     */
    private function robokassa(Request $request)
    {
        $enabled = $request->get('robokassa_enabled');
        $login = $request->get('robokassa_login');
        $password1 = $request->get('robokassa_password1');
        $password2 = $request->get('robokassa_password2');
        $algo = $request->get('robokassa_algo');
        $isTest = (bool)$request->get('robokassa_test');

        if (!$this->checkAlgo($algo, 'robokassa')) {
            throw New \UnexpectedValueException();
        }

        s_set([
            'payment.method.robokassa.enabled' => (bool)$enabled,
            'payment.method.robokassa.login' => $login,
            'payment.method.robokassa.password1' => $password1,
            'payment.method.robokassa.password2' => $password2,
            'payment.method.robokassa.algo' => $algo,
            'payment.method.robokassa.test' => $isTest,
        ]);
        s_save();
    }

    /**
     * Save settings for interkassa.
     *
     * @param Request $request
     */
    private function interkassa(Request $request)
    {
        $enabled = $request->get('interkassa_enabled');
        $login = $request->get('interkassa_checkout_id');
        $key = $request->get('interkassa_key');
        $testKey = $request->get('interkassa_test_key');
        $currency = $request->get('interkassa_currency');
        $algo = $request->get('interkassa_algo');
        $isTest = (bool)$request->get('interkassa_test');

        if (!$this->checkAlgo($algo, 'interkassa')) {
            throw New \UnexpectedValueException();
        }

        s_set([
            'payment.method.interkassa.enabled' => (bool)$enabled,
            'payment.method.interkassa.checkout_id' => $login,
            'payment.method.interkassa.key' => $key,
            'payment.method.interkassa.test_key' => $testKey,
            'payment.method.interkassa.currency' => (string)$currency,
            'payment.method.interkassa.algo' => $algo,
            'payment.method.interkassa.test' => $isTest,
        ]);
        s_save();
    }

    /**
     * Check algo on correct name.
     *
     * @param string $algo
     * @param string $service
     *
     * @return bool
     */
    public function checkAlgo($algo, $service)
    {
        $prop = $service . 'Algos';

        if (in_array($algo, $this->$prop)) {
            return true;
        }

        return false;
    }
}
