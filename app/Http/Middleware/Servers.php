<?php

namespace App\Http\Middleware;

use App\Repositories\ServerRepository;
use Closure;
use Illuminate\Http\Request;

/**
 * Class Servers
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Middleware
 */
class Servers
{
    /**
     * @var ServerRepository
     */
    private $serverRepository;

    /**
     * @param ServerRepository $repository
     */
    public function __construct(ServerRepository $repository)
    {
        $this->serverRepository = $repository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param  string                   $mode
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $mode)
    {
        if ($mode == 'one') {
            $currentServer = $this->getCurrentServer($request->route('server'));

            if (!$currentServer) {
                \App::abort(404);
            }

            if (!$currentServer->enabled and !is_admin()) {
                \App::abort(403);
            }
            $request->merge([
                'currentServer' => $currentServer
            ]);

            return $next($request);
        } elseif ($mode == 'all') {
            $servers = $this->getServers();

            foreach ($servers as $server) {
                if ($server->id == $request->route('server')) {
                    if (!$server->enabled and !is_admin()) {
                        \App::abort(403);
                    }

                    $request->merge([
                        'currentServer' => $server
                    ]);
                    break;
                }
            }

            if (!$request->get('currentServer') and $request->route('server')) {
                \App::abort(404);
            }

            $request->merge([
                'servers' => $servers
            ]);

            return $next($request);
        }

        \App::abort(403);
    }

    /**
     * @param $server
     *
     * @return mixed
     */
    private function getCurrentServer($server)
    {
        return $this->serverRepository->find((int)$server, ['id', 'name', 'enabled', 'ip', 'port', 'password', 'monitoring_enabled']);
    }

    /**
     * Get all enabled servers
     *
     * @return mixed
     */
    private function getServers()
    {
        return $this->serverRepository->all(['id', 'name', 'enabled', 'ip', 'port', 'password', 'monitoring_enabled']);
    }
}
