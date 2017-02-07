<?php

namespace App\Http\Middleware;

use Closure;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (is_auth()) {
            return $next($request);
        }

        if ($request->isMethod('get')) {
            return redirect()->route('signin');
        }

        return response()->json([
            'status' => 'not_auth'
        ]);
    }
}
