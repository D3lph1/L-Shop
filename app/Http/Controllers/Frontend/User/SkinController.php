<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\User;

use App\Handlers\Api\User\SkinHandler;
use App\Http\Controllers\Controller;
use App\Services\Auth\Exceptions\UserDoesNotExistException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SkinController extends Controller
{
    public function front(Request $request, SkinHandler $handler)
    {
        try {
            $image = $handler->front($request->route('username'));

            return response($image->encode('png'), 200, [
                'Content-Type' => 'image/png'
            ]);
        } catch (UserDoesNotExistException $e) {
            throw new NotFoundHttpException();
        }
    }

    public function back(Request $request, SkinHandler $handler)
    {
        try {
            $image = $handler->back($request->route('username'));

            return response($image->encode('png'), 200, [
                'Content-Type' => 'image/png'
            ]);
        } catch (UserDoesNotExistException $e) {
            throw new NotFoundHttpException();
        }
    }
}
