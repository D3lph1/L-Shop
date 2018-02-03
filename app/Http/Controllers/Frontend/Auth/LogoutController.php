<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\Auth;
use Illuminate\Http\RedirectResponse;

class LogoutController extends Controller
{
    public function handle(Auth $auth): RedirectResponse
    {
        $auth->logout();

        return redirect()->route('frontend.auth.login.render');
    }
}
