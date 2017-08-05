<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;

/**
 * Class WaitController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Payment
 */
class WaitController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function interkassa()
    {
        return $this->handle();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    private function handle()
    {
        $this->msg->info(__('messages.payments.wait'));

        return redirect()->route('index');
    }
}
