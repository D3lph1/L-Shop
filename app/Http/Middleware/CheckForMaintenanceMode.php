<?php
declare(strict_types = 1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;

/**
 * Class CheckForMaintenanceMode
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Middleware
 */
class CheckForMaintenanceMode extends \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode
{
    /**
     * The list of excepted routes that will be available even when the app is down
     *
     * @var array
     */
    protected $except = [
        'signin.post',
        'api.signin',
        'signin'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $f = false;
        if ($this->app->isDownForMaintenance()) {
            foreach ($this->except as $except) {
                if ($except == \Route::currentRouteName()) {
                    $f = true;
                    break;
                }
            }

            if (!(is_admin() or $f)) {
                $data = json_decode(file_get_contents($this->app->storagePath() . '/framework/down'), true);

                throw new MaintenanceModeException($data['time'], $data['retry'], $data['message']);
            }
        }

        return $next($request);
    }
}
