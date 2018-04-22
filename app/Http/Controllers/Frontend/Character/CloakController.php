<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Character;

use App\Handlers\Api\User\CloakHandler;
use App\Http\Controllers\Controller;
use App\Services\Auth\Exceptions\UserDoesNotExistException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CloakController extends Controller
{
    public function front(Request $request, CloakHandler $handler)
    {
        try {
            $image = $handler->front($request->route('username'));

            // If cloak does not exists, return empty response.
            if ($image === null) {
                return response('');
            }

            return response($image->encode('png'), 200, [
                'Content-Type' => 'image/png'
            ]);
        } catch (UserDoesNotExistException $e) {
            throw new NotFoundHttpException();
        }
    }

    public function back(Request $request, CloakHandler $handler)
    {
        try {
            $image = $handler->back($request->route('username'));

            // If cloak does not exists, return empty response.
            if ($image === null) {
                return response('');
            }

            return response($image->encode('png'), 200, [
                'Content-Type' => 'image/png'
            ]);
        } catch (UserDoesNotExistException $e) {
            throw new NotFoundHttpException();
        }
    }
}
