<?php

namespace App\Http\Controllers\Admin\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class ListController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\Users
 */
class ListController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        $users = \Sentinel::getUserRepository()->with(['roles', 'activations'])->paginate(50);

        $data = [
            'currentServer' => $request->get('currentServer'),
            'users' => $users
        ];

        return view('admin.users.list', $data);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
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
