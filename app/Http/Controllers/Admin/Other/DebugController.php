<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Other;

use App\Http\Requests\Admin\TestMailRequest;
use App\Services\Mailer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Session\SessionManager;
use Illuminate\View\View;
use Psr\Log\LoggerInterface;

/**
 * Class DebugController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin\Other
 */
class DebugController extends Controller
{
    /**
     * Render debug page.
     */
    public function render(Request $request): View
    {
        $data = [
            'currentServer' => $request->get('currentServer')
        ];

        return view('admin.other.debug', $data);
    }

    /**
     * Send test message on given email.
     */
    public function testMail(TestMailRequest $request, Mailer $mailer, LoggerInterface $logger, SessionManager $session): RedirectResponse
    {
        $address = $request->get('test_mail_address');
        $error = false;

        try {
            $mailer->sendTest($address);
        } catch (\Exception $e) {
            $logger->error($e);
            // Write debug information in the flash session for user.
            $session->flash('test_mail_exception', $e->getMessage());
            $error = true;
        }

        if ($error) {
            $this->msg->danger(__('messages.admin.other.debug.mail.fail'));
        } else {
            $this->msg->success(__('messages.admin.other.debug.mail.success'));
        }

        return back();
    }
}
