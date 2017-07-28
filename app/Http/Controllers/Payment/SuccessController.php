<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class SuccessController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Payment
 */
class SuccessController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function robokassa(Request $request)
    {
        $this->msg->success(__('messages.payments.success'));

        return response()->redirectToRoute('servers');
    }
}
