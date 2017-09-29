<?php
declare(strict_types = 1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * Class RedirectIfAuthenticated
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Middleware
 */
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
