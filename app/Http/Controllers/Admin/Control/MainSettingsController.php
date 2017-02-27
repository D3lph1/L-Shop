<?php

namespace App\Http\Controllers\Admin\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainSettingsController extends Controller
{
    public function render(Request $request)
    {
        return view('admin.control.main_settings');
    }
}
