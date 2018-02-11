<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Information;

use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function render()
    {
        return view('admin.information.about');
    }
}
