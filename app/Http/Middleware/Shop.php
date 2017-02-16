<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\QueryManager;

/**
 * Class Shop
 * Middleware, called pages, working with a shop layout
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Middleware
 */
class Shop
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
        $data = [
            'currentServer' => $this->getCurrentServer($request->route('server')),
            'servers' => $this->getServers(),
        ];
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
