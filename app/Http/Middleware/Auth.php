<?php
declare(strict_types = 1);

namespace App\Http\Middleware;

use App\Services\Message;
use Closure;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;

/**
 * Class Auth
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Middleware
 */
class Auth
{
    /**
     * @var Container
     */
    protected $container;

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
     * Auth constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

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
                    $this->container->make('app')->abort(403);
                }

                return $next($request);
        }

        throw new \InvalidArgumentException(
            'mode(auth) must be has next values: "guest", "soft", "hard", "admin". ' . $mode . ' given'
        );
    }

    /**
     * Construct response.
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
            $this->container->make(Message::class)->warning($message);
        }

        return response()->redirectToRoute($redirect);
    }
}
