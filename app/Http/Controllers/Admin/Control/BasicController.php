<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BasicController extends Controller
{
    public function render()
    {
        return view('admin.control.basic');
    }
}
