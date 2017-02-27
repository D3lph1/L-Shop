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
            $request->merge([
                'currentServer' => $this->getCurrentServer($request->route('server'))
            ]);

            return $next($request);
        } elseif ($mode == 'all') {
            $servers = $this->getServers();

            foreach ($servers as $server) {
                if ($server->id == $request->route('server')) {
                    $request->merge([
                        'servers' => $servers,
                        'currentServer' => $server
                    ]);
                    break;
                }
            }

            return $next($request);
        }

        \App::abort(404);
    }

    /**
     * @param $server
     *
     * @return mixed
     */
    private function getCurrentServer($server)
    {
        return $this->qm->serverOrFail($server, ['id', 'name']);
    }

    /**
     * Get all enabled servers
     *
     * @return mixed
     */
    private function getServers()
    {
        return $this->qm->listOfEnabledServers(['id', 'name']);
    }
}
