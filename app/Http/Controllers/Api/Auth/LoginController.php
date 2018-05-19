<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\ForbiddenException;
use App\Handlers\Api\Auth\LoginHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function App\signed_middleware;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware(signed_middleware(['username', 'password']))->only('login');
    }

    public function login(Request $request, LoginHandler $handler): Response
    {
        try {
            if ($handler->handle($request->get('username'), $request->get('password'))) {
                return new RedirectResponse('/');
            }

            return new Response('', Response::HTTP_BAD_REQUEST);
        } catch (ForbiddenException $e) {
            return new Response('', Response::HTTP_FORBIDDEN);
        }
    }
}
