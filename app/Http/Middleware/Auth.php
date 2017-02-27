<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Class Auth
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Middleware
 */
class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $mode)
    {
        switch ($mode) {
            case 'guest':
                if (access_mode_guest()) {
                    return $this->response($request, 'servers', 'not allowed');
                }

                if (is_auth()) {
                    return $this->response($request, 'servers', 'only guests');
                }

                return $next($request);

            case 'soft':
                if (access_mode_auth() and !is_auth()) {
                    return $this->response($request, 'signin', 'not auth');
                }

                return $next($request);

            case 'hard':
                if (!is_auth()) {
                    return $this->response($request, 'signin', 'not auth');
                }

                return $next($request);

            case 'admin':
                if (!is_admin()) {
                    \App::abort(403);
                }

                return $next($request);
        }
    }

    /**
     * Construct response
     *
     * @param Request $request
     * @param string  $redirect
     * @param string  $jsonResponse
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    private function response($request, $redirect, $jsonResponse)
    {
        if (strtolower($request->method()) === 'post' or $request->ajax()) {
            return json_response($jsonResponse);
        }

        return response()->redirectToRoute($redirect);
    }
}
