<?php
declare(strict_types = 1);

namespace App\Http\Middleware;

use App\Services\Auth\Auth;
use Closure;
use Symfony\Component\HttpKernel\Exception\HttpException;

class NeedPermission
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
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param string                    $permission
     *
     * @return mixed
     */
    public function handle($request, Closure $next, string $permission)
    {
        if (!$this->auth->check()) {
            throw new HttpException(403);
        }

        if ($this->auth->getUser()->hasPermission($permission)) {
            return $next($request);
        }

        throw new HttpException(403);
    }
}
