<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\Api\InvalidIpAddressException;
use App\Exceptions\ForbiddenException;
use App\Handlers\Api\Auth\Sashok724sV3Handler;
use App\Http\Controllers\Controller;
use App\Services\Auth\Exceptions\BannedException;
use App\Services\Auth\Exceptions\NotActivatedException;
use App\Services\Auth\Exceptions\ThrottlingException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Sashok724sV3LauncherController extends Controller
{
    /**
     * <p>Notice: http code of errors must be equal to 200 so that the server displays the message by the user.</p>
     *
     * @param Request             $request
     * @param Sashok724sV3Handler $handler
     *
     * @return Response
     */
    public function authenticate(Request $request, Sashok724sV3Handler $handler): Response
    {
        try {
            $response = $handler->handle($request->get('username'), $request->get('password'), $request->ip());
            if ($response !== null) {
                return new Response($response);
            }

            return new Response(__('msg.frontend.auth.login.invalid_credentials'));
        } catch (NotActivatedException $e) {
            return new Response(__('msg.frontend.auth.login.not_activated'));
        } catch (BannedException $e) {
            return new Response(__('msg.api.auth.sashok724sV3Launcher.banned'));
        } catch (ThrottlingException $e) {
            return new Response(__('msg.api.auth.sashok724sV3Launcher.throttling', ['cooldown' => $e->getCooldownRemaining()]));
        } catch (InvalidIpAddressException $e) {
            return new Response(__('msg.api.auth.sashok724sV3Launcher.ip_not_in_whitelist'));
        } catch (ForbiddenException $e) {
            return new Response(__('msg.api.auth.sashok724sV3Launcher.disabled'));
        }
    }
}
