<?php

namespace App\Http\Middleware;

use Closure;

class DenyIfModeAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (access_mode_auth() and !is_auth()) {
            if ($request->ajax() or $request->method() == 'post') {
                return json_response('deny');
            }

            return response()->redirectToRoute('signin');
        }

        return $next($request);
    }
}
