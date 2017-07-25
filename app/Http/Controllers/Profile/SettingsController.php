<?php

namespace App\Http\Controllers\Profile;

use App\Http\Requests\Admin\SaveChangedPasswordRequest;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class SettingsController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Profile
 */
class SettingsController extends Controller
{
    /**
     * Render profile settings page.
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

    /**
     * Change password from profile.
     *
     * @param SaveChangedPasswordRequest $request
     * @param Sentinel                   $sentinel
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(SaveChangedPasswordRequest $request, Sentinel $sentinel)
    {
        if (!s_get('user.enable_change_password', false)) {
            $this->msg->danger(__('messages.profile.password.disabled'));

            return back();
        }

        $user = $sentinel->getUser();
        $result = $sentinel->getUserRepository()->update($user, [
            'password' => $request->get('password')
        ]);

        if ($result) {
            $this->msg->success(__('messages.profile.password.success'));
        }else {
            $this->msg->danger(__('messages.profile.password.fail'));
        }

        return back();
    }

    /**
     * Reset login-sessions for current user.
     *
     * @param Sentinel $sentinel
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sessions(Sentinel $sentinel)
    {
        $sentinel->logout(null, true);
        $this->msg->info(__('messages.profile.settings.sessions'));

        return back();
    }
}
