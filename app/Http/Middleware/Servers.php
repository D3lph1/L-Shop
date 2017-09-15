<?php
declare(strict_types = 1);

namespace App\Http\Middleware;

use App\Models\Server\ServerInterface;
use App\Repositories\Server\ServerRepositoryInterface;
use Closure;
use Illuminate\Http\Request;

/**
 * Class Server
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Middleware
 */
class Servers
{
    /**
     * @var ServerRepositoryInterface
     */
    private $serverRepository;

    public function __construct(ServerRepositoryInterface $repository)
    {
        $this->serverRepository = $repository;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $mode)
    {
        if ($mode == 'one') {
            $currentServer = $this->getCurrentServer((int)$request->route('server'));

            if (!$currentServer) {
                \App::abort(404);
            }

            if (!$currentServer->isEnabled() and !is_admin()) {
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

        // Unreachable statement. For IDE.
        return $next($request);
    }

    private function getCurrentServer(int $server): ?ServerInterface
    {
        return $this->serverRepository->find((int)$server, ['id', 'name', 'enabled', 'ip', 'port', 'password', 'monitoring_enabled']);
    }

    /**
     * Get all enabled servers
     */
    private function getServers(): iterable
    {
        return $this->serverRepository->all(['id', 'name', 'enabled', 'ip', 'port', 'password', 'monitoring_enabled']);
    }
}
