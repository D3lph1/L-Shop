<?php

namespace App\Http\Controllers\Admin\Other;

use App\Http\Requests\Admin\TestMailRequest;
use App\Services\Mailer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class DebugController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\Other
 */
class DebugController extends Controller
{
    /**
     * Render debug page.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        $data = [
            'currentServer' => $request->get('currentServer')
        ];

        return view('admin.other.debug', $data);
    }

    /**
     * Send test message on given email.
     *
     * @param TestMailRequest $request
     * @param Mailer          $mailer
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function testMail(TestMailRequest $request, Mailer $mailer)
    {
        $address = $request->get('test_mail_address');
        $error = false;

        try {
            $mailer->sendTest($address);
        } catch (\Exception $e) {
            \Log::error($e);
            // Write debug information in the flash session for user.
            \Session::flash('test_mail_exception', $e->getMessage());
            $error = true;
        }

        if ($error) {
            \Message::danger('Сообщение отправить не удалось.');
        } else {
            \Message::success('Сообщение успешно отправлено!');
        }

        return back();
    }
}
