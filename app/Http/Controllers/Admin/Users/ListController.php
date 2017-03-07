<?php

namespace App\Http\Controllers\Admin\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListController extends Controller
{
    public function render(Request $request)
    {
        $users = \Sentinel::getUserRepository()->with(['roles', 'activations'])->paginate(50);

        $data = [
            'currentServer' => $request->get('currentServer'),
            'users' => $users
        ];

        return view('admin.users.list', $data);
    }

    public function complete(Request $request)
    {
        $user = \Sentinel::findById((int)$request->route('user'));
        $activation = \Activation::completed($user);
        if ($activation) {
            \Message::info('Аккаунт пользователя уже подтвержден');

            return back();
        }

        \Sentinel::activate($user);
        \Message::success('Аккаунт пользователя подтвержден');

        return back();
    }
}
