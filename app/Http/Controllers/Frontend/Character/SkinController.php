<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Character;

use App\Handlers\Api\User\SkinHandler;
use App\Http\Controllers\Controller;
use App\Services\Auth\Exceptions\UserDoesNotExistException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class SkinController
 * Responsible for displaying images of the skin sides.
 */
class SkinController extends Controller
{
    /**
     * It is responsible for the output of the front side of the skin image.
     *
     * @param Request     $request
     * @param SkinHandler $handler
     *
     * @return Response
     */
    public function front(Request $request, SkinHandler $handler): Response
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

    /**
     * It is responsible for the output of the back side of the skin image.
     *
     * @param Request     $request
     * @param SkinHandler $handler
     *
     * @return Response
     */
    public function back(Request $request, SkinHandler $handler): Response
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
