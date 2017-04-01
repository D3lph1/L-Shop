<?php

namespace App\Http\Controllers\Profile;

use App\Http\Requests\Admin\SaveChangedPasswordRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    /**
     * Render profile settings page
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        $data = [
            'servers' => $request->get('servers'),
            'currentServer' => $request->get('currentServer'),
            'enableChangePassword' => s_get('user.enable_change_password', false)
        ];

        return view('profile.settings', $data);
    }

    public function password(SaveChangedPasswordRequest $request)
    {
        if (!s_get('user.enable_change_password', false)) {
            \Message::danger('Возможность смены пароля отключена');

            return back();
        }

        $user = \Sentinel::getUser();
        $result = \Sentinel::update($user, [
            'password' => $request->get('password')
        ]);

        if ($result) {
            \Message::success('Пароль успешно изменен!');
        }else {
            \Message::danger('Не удалось изменить пароль');
        }

        return back();
    }

    public function sessions(Request $request)
    {
        \Sentinel::logout(null, true);
        \Message::info('Сессии сброшены');

        return back();
    }
}
