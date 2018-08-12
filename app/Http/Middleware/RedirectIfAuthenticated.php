<?php
declare(strict_types = 1);

namespace App\Http\Middleware;

use App\Services\Auth\Auth;
use App\Services\Response\JsonResponse;
use Closure;

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
            return new \Illuminate\Http\JsonResponse((new JsonResponse('guest'))->jsonSerialize());
        }

        return $next($request);
    }
}
