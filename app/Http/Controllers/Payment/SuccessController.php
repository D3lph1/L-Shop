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
    public function robokassa(Request $request)
    {
        print_r($request->all());
    }
}
