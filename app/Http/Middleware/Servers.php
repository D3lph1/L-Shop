<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\QueryManager;

class Servers
{
    /**
     * @var QueryManager
     */
    private $qm;

    /**
     * @param QueryManager $qm
     */
    public function __construct(QueryManager $qm)
    {
        $this->qm = $qm;
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
        return $this->qm->server($server, ['id', 'name', 'enabled']);
    }

    /**
     * Get all enabled servers
     *
     * @return mixed
     */
    private function getServers()
    {
        return $this->qm->listOfServers(['id', 'name', 'enabled']);
    }
}
