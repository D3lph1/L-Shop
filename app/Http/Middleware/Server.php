<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\QueryManager;

class Server
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $servers = $request->get('servers');
        $data = [];
        // If request already exists servers list
        if ($servers) {
            foreach ($servers as $server) {
                if ($server->id == $request->route('server')) {
                    $data = [
                        'currentServer' => $server
                    ];
                }
            }
        }else {
            $data = [
                'currentServer' => $this->getCurrentServer($request->route('server'))
            ];
        }
        $request->merge($data);

        return $next($request);
    }

    /**
     * @param $server
     * @return mixed
     */
    private function getCurrentServer($server)
    {
        return $this->qm->serverOrFail($server, ['id', 'name']);
    }
}
