<?php
declare(strict_types = 1);

namespace App\Http\Middleware;

use App\Exceptions\UnexpectedValueException;
use App\Services\Security\Accessors\Accessor;
use Closure;
use Illuminate\Contracts\Container\Container;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PassAccessor
{
    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param string                    $accessorName
     *
     * @return mixed
     */
    public function handle($request, Closure $next, string $accessorName)
    {
        $accessor = $this->container->make($accessorName);
        if (!($accessor instanceof Accessor)) {
            throw new UnexpectedValueException(
                "Accessor class must be implements interface App\Services\Security\Accessors\Accessor"
            );
        }

        if ($this->container->call([$accessor, 'resolve'])) {
            return $next($request);
        }

        throw new HttpException(403);
    }
}
