<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Api\Auth;

use App\Handlers\Api\Auth\RegisterHandler;
use App\Http\Controllers\Controller;
use App\Services\Auth\Exceptions\EmailAlreadyExistsException;
use App\Services\Auth\Exceptions\UsernameAlreadyExistsException;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;
use function App\signed_middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware(signed_middleware(['email', 'username', 'password', 'send_activation', 'authenticate']))
            ->only('register');
    }

    public function register(Request $request, RegisterHandler $handler): JsonResponse
    {
        try {
            $dto = $handler->handle(
                $request->get('username'),
                $request->get('email'),
                $request->get('password'),
                (bool)$request->get('send_activation'),
                (bool)$request->get('authenticate')
            );

            if ($dto->isSuccessfully()) {
                return new JsonResponse(Status::SUCCESS);
            } else {
                return (new JsonResponse(Status::FAILURE))
                    ->setHttpStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (UsernameAlreadyExistsException $e) {
            return (new JsonResponse('username_already_exists'))
                ->setHttpStatus(Response::HTTP_NOT_FOUND);
        } catch (EmailAlreadyExistsException $e) {
            return (new JsonResponse('email_already_exists'))
                ->setHttpStatus(Response::HTTP_NOT_FOUND);
        }
    }
}
