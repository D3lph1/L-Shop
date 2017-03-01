<?php

namespace App\Http\Controllers\Admin\Control;

use App\Http\Requests\Admin\SaveSecurityRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SecurityController extends Controller
{
    public function render(Request $request)
    {
        $data = [
            'currentServer' => $request->get('currentServer'),
            'recaptchaPublicKey' => s_get('recaptcha.public_key'),
            'recaptchaSecretKey' => s_get('recaptcha.secret_key')
        ];

        return view('admin.control.security', $data);
    }

    public function save(SaveSecurityRequest $request)
    {
        s_set([
            'recaptcha.public_key' => $request->get('recaptcha_public_key'),
            'recaptcha.secret_key' => $request->get('recaptcha_secret_key')
        ]);
        s_save();

        \Message::success('Изменения успешно сохранены!');

        return back();
    }
}
