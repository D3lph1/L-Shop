<?php

namespace App\Http\Controllers\Admin\Items;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddController extends Controller
{
    public function render(Request $request)
    {
        $data = [
            'currentServer' => $request->get('currentServer')
        ];

        return view('admin.items.add', $data);
    }

    public function save()
    {
        //
    }
}
