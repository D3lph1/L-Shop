<?php

namespace App\Http\Controllers\Admin\Control;

use App\Http\Requests\Admin\SavePaymentsRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentsController extends Controller
{
    private $robokassaAlgos = [
        'md5',
        'ripemd160',
        'sha1',
        'sha256',
        'sha384',
        'sha512'
    ];

    public function render(Request $request)
    {
        $data = [
            'currentServer' => $request->get('currentServer'),
            'minSum' => s_get('payment.fillupbalance.minsum'),
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
        //
    }
}
