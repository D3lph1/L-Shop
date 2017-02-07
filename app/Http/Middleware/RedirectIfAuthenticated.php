<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        if (is_auth()) {
            if ($request->isMethod('get')) {
                return redirect()->route('servers');
            }

            return response()->json(['status' => 'allready_auth']);
        }

        return $next($request);
    }
}
