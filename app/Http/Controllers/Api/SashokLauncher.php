<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\SashokLauncherAuthWhiteListException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class SashokLauncher
 * Integration Sashok724's launcher in L-Shop system
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Api
 */
class SashokLauncher extends ApiController
{
    public function __construct()
    {
        // Disable debugbar on this actions
        \Debugbar::disable();

        parent::__construct();
    }

    /**
     * Handle authenticate request
     *
     * @param Request                      $request
     * @param \App\Services\SashokLauncher $handler
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|string|\Symfony\Component\HttpFoundation\Response
     */
    public function auth(Request $request, \App\Services\SashokLauncher $handler)
    {
        if (!$this->isEnabled('launcher.sashok.auth')) {
            return response('Функция отключена');
        }

        $username = $request->get('username');
        $password = $request->get('password');
        $ip = $request->ip();

        try {
            $username = $handler->checkCredentials(
                $username,
                $password,
                $ip,
                s_get('api.launcher.sashok.auth.ips_white_list')
            );
        } catch (SashokLauncherAuthWhiteListException $e) {
            return response('Доступ запрещен');
        }

        if ($username) {
            $foramt = s_get('api.launcher.sashok.auth.format');

            // Replace username maker in response format
            return str_replace('{username}', $username, $foramt);
        }

        return response(s_get('api.launcher.sashok.auth.error_message'));
    }
}
