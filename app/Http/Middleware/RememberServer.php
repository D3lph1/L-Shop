<?php
declare(strict_types = 1);

namespace App\Http\Middleware;

use App\Services\Infrastructure\Server\Persistence\Persistence;
use Closure;
use Illuminate\Http\Request;

class RememberServer
{
    /**
     * @var Persistence
     */
    private $persistence;

    public function __construct(Persistence $persistence)
    {
        $this->persistence = $persistence;
    }

    public function handle(Request $request, Closure $next)
    {
        //
    }
}
