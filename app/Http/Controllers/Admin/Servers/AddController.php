<?php

namespace App\Http\Controllers\Admin\Servers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddController extends Controller
{
    public function render()
    {
        return view('admin.servers.add');
    }
}
