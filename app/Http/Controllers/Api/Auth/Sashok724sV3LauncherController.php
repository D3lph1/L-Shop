<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\ForbiddenException;
use App\Handlers\Api\Auth\Sashok724sV3Handler;
use App\Http\Controllers\Controller;
use App\Services\Auth\Exceptions\BannedException;
use App\Services\Auth\Exceptions\NotActivatedException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Sashok724sV3LauncherController extends Controller
{
    /**
     * Notice: http code of errors must be equal to 200 so that the server displays the message by the user.
     *
     * @param Request             $request
     * @param Sashok724sV3Handler $handler
     *
     * @return Response
     */
    public function authenticate(Request $request, Sashok724sV3Handler $handler): Response
    {
        try {
            $response = $handler->handle($request->get('username'), $request->get('password'));
            if ($response !== null) {
                return new Response($response);
            }

            return new Response(__('msg.frontend.auth.login.invalid_credentials'));
        } catch (NotActivatedException $e) {
            return new Response(__('msg.frontend.auth.login.not_activated'));
        } catch (BannedException $e) {
            return new Response(__('msg.api.auth.sashok724sV3Launcher.banned'));
        } catch (ForbiddenException $e) {
            return new Response(__('msg.api.auth.sashok724sV3Launcher.disabled'));
        }
    }
}
