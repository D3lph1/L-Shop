<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Auth;

use App\Exceptions\User\NotFoundException;
use App\Exceptions\User\RemindCodeNotFound;
use App\Exceptions\User\UnableToCompleteRemindException;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\Reminder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Psr\Log\LoggerInterface;

/**
 * Class ForgotPasswordController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Auth
 */
class ForgotPasswordController extends Controller
{
    /**
     * @var Reminder
     */
    private $reminder;

    public function __construct(Reminder $reminder)
    {
        $this->reminder = $reminder;
        parent::__construct();
    }

    /**
     * Render forgot password page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        if ($this->isDisabled()) {
            return response()->redirectToRoute('index');
        }

        return view('auth.forgot');
    }

    /**
     * Handle forgot password request.
     */
    public function handle(ForgotPasswordRequest $request): RedirectResponse
    {
        if ($this->isDisabled()) {
            return response()->redirectToRoute('index');
        }
        $email = $request->get('email');

        try {
            $this->reminder->forgot($email, $request->ip());
        } catch (NotFoundException $e) {
            $this->msg->danger(__('messages.auth.forgot.user_not_found'));

            return back();
        }
        $this->msg->info(__('messages.auth.forgot.success'));

        return back();
    }

    /**
     * Render reset password page
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function renderResetPasswordPage(Request $request)
    {
        if ($this->isDisabled()) {
            return response()->redirectToRoute('index');
        }

        $user = (int)$request->route('user');
        $code = $request->route('code');

        if (!$this->reminder->checkCode($user, $code)) {
            $this->msg->danger(__('messages.auth.reset.invalid_code'));

            return response()->redirectToRoute('index');
        }

        $data = [
            'user' => $user,
            'code' => $code
        ];

        return view('auth.reset_password', $data);
    }

    /**
     * Handle reset password request
     */
    public function resetPassword(ResetPasswordRequest $request, LoggerInterface $logger): RedirectResponse
    {
        if ($this->isDisabled()) {
            return response()->redirectToRoute('index');
        }

        $userId = (int)$request->route('user');
        $code = $request->route('code');
        $password = $request->get('password');

        try {
            $this->reminder->reset($userId, $code, $password);
        } catch (RemindCodeNotFound $e) {
            $this->msg->danger(__('messages.auth.reset.invalid_code'));

            return response()->redirectToRoute('index');
        } catch (UnableToCompleteRemindException $e) {
            $logger->error($e);
            $this->msg->danger(__('messages.auth.reset.fail'));

            return response()->redirectToRoute('index');
        }

        $this->msg->success(__('messages.auth.reset.success'));

        return response()->redirectToRoute('signin');
    }

    private function isDisabled(): bool
    {
        if (!s_get('shop.enable_password_reset')) {
            $this->msg->warning(__('messages.auth.forgot.disabled'));

            return true;
        }

        return false;
    }
}
