<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\Auth;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use Illuminate\Http\RedirectResponse;

/**
 * Class LogoutController
 * Handles requests related to logout user.
 */
class LogoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Processes the user's logon request.
     *
     * @param Auth $auth
     *
     * @return JsonResponse
     */
    public function handle(Auth $auth): JsonResponse
    {
        $auth->logout();

        return new JsonResponse(Status::SUCCESS);
    }
}
