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
     * Available hash algos for robokassa
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

    /**
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
            'robokassaLogin' => s_get('payment.method.robokassa.login'),
            'robokassaPassword1' => s_get('payment.method.robokassa.password1'),
            'robokassaPassword2' => s_get('payment.method.robokassa.password2'),
            'robokassaAlgo' => s_get('payment.method.robokassa.algo'),
            'robokassaIsTest' => (bool)s_get('payment.method.robokassa.test'),
            'robokassaAlgos' => $this->robokassaAlgos
        ];

        return view('admin.control.payments', $data);
    }

    public function save(SavePaymentsRequest $request)
    {
        $this->all($request);

        try {
            $this->robokassa($request);
        } catch (\UnexpectedValueException $e) {
            if ($e->getCode() === 1) {
                \Message::danger('Такого алгоритма расчета контрольной суммы нет в списке');

                return back();
            }
        }
        \Message::success('Изменения успешно сохранены!');

        return back();
    }

    /**
     * Save all settings
     *
     * @param $request
     */
    private function all($request)
    {
        s_set('payment.fillupbalance.minsum', $request->get('min_sum'));
        s_save();
    }

    /**
     * Save settings for robokassa
     *
     * @param $request
     */
    private function robokassa($request)
    {
        $login = $request->get('robokassa_login');
        $password1 = $request->get('robokassa_password1');
        $password2 = $request->get('robokassa_password2');
        $algo = $request->get('robokassa_algo');
        $isTest = $request->get('robokassa_test');

        if (!$this->checkAlgo($algo, 'robokassa')) {
            throw New \UnexpectedValueException('', 1);
        }

        s_set([
            'payment.method.robokassa.login' => $login,
            'payment.method.robokassa.password1' => $password1,
            'payment.method.robokassa.password2' => $password2,
            'payment.method.robokassa.algo' => $algo,
            'payment.method.robokassa.test' => $isTest,
        ]);
        s_save();
    }

    /**
     * Check algo on correct name
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
