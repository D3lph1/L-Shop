<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Api;

use App\Exceptions\SashokLauncherAuthWhiteListException;
use App\Exceptions\User\BannedException;
use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SashokLauncher
 * Integration Sashok724's launcher in L-Shop system.
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Api
 */
class SashokLauncher extends ApiController
{
    /**
     * SashokLauncher constructor.
     */
    public function __construct()
    {
        // Disable debugbar on this actions for authorization to work even in debug mode.
        \Debugbar::disable();

        parent::__construct();
    }

    /**
     * Handle authenticate request.
     */
    public function auth(Request $request, \App\Services\SashokLauncher $handler): Response
    {
        if (!$this->isEnabled('launcher.sashok.auth')) {
            return response(__('messages.api.disabled'));
        }

        $username = $request->get('username');
        $password = $request->get('password');
        $ip = $request->ip();

        try {
            $username = $handler->auth(
                $username,
                $password,
                $ip,
                s_get('api.launcher.sashok.auth.ips_white_list')
            );
        } catch (SashokLauncherAuthWhiteListException $e) {
            return response(__('messages.api.forbidden'), 403);
        } catch (NotActivatedException $e) {
            return response(__('messages.auth.signin.not_activated'));
        } catch (BannedException $e) {
            return response(build_ban_message($e->getUntil(), $e->getReason()));
        }

        if ($username) {
            $format = s_get('api.launcher.sashok.auth.format');

            // Replace username marker in response format.
            return response(str_replace('{username}', $username, $format));
        }

        return response(s_get('api.launcher.sashok.auth.error_message'));
    }
}
