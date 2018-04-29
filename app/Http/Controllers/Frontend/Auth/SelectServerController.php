<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Auth;

use function App\auth_middleware;
use App\Handlers\Frontend\Auth\ServersHandler;
use App\Http\Controllers\Controller;
use App\Http\Middleware\Auth;
use App\Services\Auth\AccessMode;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use App\Services\Settings\Settings;

class SelectServerController extends Controller
{
    public function __construct()
    {
        $this->middleware(auth_middleware(Auth::SOFT));
    }

    public function render(ServersHandler $handler, Settings $settings)
    {
        return new JsonResponse(Status::SUCCESS, array_merge($handler->servers()->jsonSerialize(), [
            'allowLogin' => $settings->get('auth.access_mode')->getValue() === AccessMode::ANY ||
                $settings->get('auth.access_mode')->getValue() === AccessMode::AUTH
        ]));
    }
}
