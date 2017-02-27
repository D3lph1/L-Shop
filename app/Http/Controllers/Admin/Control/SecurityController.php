<?php

namespace App\Http\Controllers\Admin\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SecurityController extends Controller
{
    public function render(Request $request)
    {
        return view('admin.control.security');
    }
}
