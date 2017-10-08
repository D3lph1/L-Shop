<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveChangedPasswordRequest;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class SettingsController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Profile
 */
class SettingsController extends Controller
{
    /**
     * Render profile settings page.
     */
    public function render(Request $request): View
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
     */
    public function password(SaveChangedPasswordRequest $request): RedirectResponse
    {
        if (!s_get('user.enable_change_password', false)) {
            $this->msg->danger(__('messages.profile.password.disabled'));

            return back();
        }

        $user = $this->sentinel->getUser();
        $result = $this->sentinel->getUserRepository()->update($user, [
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
     */
    public function sessions(Sentinel $sentinel): RedirectResponse
    {
        $sentinel->logout(null, true);
        $this->msg->info(__('messages.profile.settings.sessions'));

        return back();
    }
}
