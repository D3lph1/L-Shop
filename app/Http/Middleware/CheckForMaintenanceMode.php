<?php
declare(strict_types  = 1);

namespace App\Http\Middleware;

use App\Services\Auth\Auth;
use App\Services\Auth\Permissions;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as BaseCheckForMaintenanceMode;
use Illuminate\Routing\Router;
use Psr\Log\LoggerInterface;

class CheckForMaintenanceMode extends BaseCheckForMaintenanceMode
{
    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var Router
     */
    private $router;

    /**
     * The list of excepted routes that will be available even when the app is down
     *
     * @var array
     */
    protected $except = [
        // Do not touch this routes.
        'spa',
        'frontend.lang.js',
        // End.

        'frontend.auth.login.render',
        'frontend.auth.login.handle'
    ];

    public function __construct(Application $app, Auth $auth, Router $router)
    {
        parent::__construct($app);
        $this->auth = $auth;
        $this->router = $router;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $f = false;
        if ($this->app->isDownForMaintenance()) {
            foreach ($this->except as $except) {
                if ($except === $this->router->currentRouteName()) {
                    $f = true;
                    break;
                }
            }
            app(LoggerInterface::class)->debug($this->auth->check());
            if (!$f && !($this->auth->check() && $this->auth->getUser()->hasPermission(Permissions::ACCESS_WHILE_MAINTENANCE))) {
                $data = json_decode(file_get_contents($this->app->storagePath() . '/framework/down'), true);
                throw new MaintenanceModeException($data['time'], $data['retry'], $data['message']);
            }
        }

        return $next($request);
    }
}
