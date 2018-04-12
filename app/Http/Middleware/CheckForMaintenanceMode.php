<?php
declare(strict_types  = 1);

namespace App\Http\Middleware;

use App\Services\Auth\Auth;
use App\Services\Auth\Permissions;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as BaseCheckForMaintenanceMode;

class CheckForMaintenanceMode extends BaseCheckForMaintenanceMode
{
    /**
     * The list of excepted routes that will be available even when the app is down
     *
     * @var array
     */
    protected $except = [
        //
    ];

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
                if ($except == \Route::currentRouteName()) {
                    $f = true;
                    break;
                }
            }
            $auth = $this->app->make(Auth::class);

            if (!$f || !$auth->check() || !($auth->check() && $auth->getUser()->hasPermission(Permissions::ACCESS_WHILE_MAINTENANCE))) {
                $data = json_decode(file_get_contents($this->app->storagePath() . '/framework/down'), true);
                throw new MaintenanceModeException($data['time'], $data['retry'], $data['message']);
            }
        }

        return $next($request);
    }
}
