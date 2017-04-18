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
     * List of except routes
     *
     * @var array
     */
    protected $except = [
        'signin.post',
        'api.signin',
        'signin'
    ];

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
                    foreach ($this->except as $except) {
                        if ($except == \Route::currentRouteName()) {
                            $request->merge(['onlyForAdmins' => true]);

                            return $next($request);
                        }
                    }

                    return $this->response($request, 'servers', 'not allowed', 'Запрещено');
                }

                if (is_auth()) {
                    return $this->response($request, 'servers', 'only guests', 'Только для гостей');
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
     * @param null|string  $message
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    private function response($request, $redirect, $jsonResponse, $message = null)
    {
        if ($request->ajax()) {
            return json_response($jsonResponse);
        }
        if (!is_null($message)) {
            \Message::warning($message);
        }

        return response()->redirectToRoute($redirect);
    }
}
