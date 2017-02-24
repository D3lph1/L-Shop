<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Class Auth
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Middleware
 */
class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (is_auth()) {
            return $next($request);
        }

        if ($request->isMethod('get')) {
            return redirect()->route('signin');
        }

        return json_response('not auth');
    }
}
