<?php
declare(strict_types = 1);

namespace App\Http\Middleware;

use App\Services\Auth\Auth;
use App\Services\Response\JsonResponse;
use Closure;

/**
 * Class RedirectIfAuthenticated
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Middleware
 */
class RedirectIfAuthenticated
{
    /**
     * @var Auth
     */
    private $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->check()) {
            return response()->json(new JsonResponse('guest'));
        }

        return $next($request);
    }
}
