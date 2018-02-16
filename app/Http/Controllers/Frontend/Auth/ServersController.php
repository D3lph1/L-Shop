<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Auth;

use App\Handlers\Frontend\Auth\ServersHandler;
use App\Http\Controllers\Controller;
use App\Services\Auth\AccessMode;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use App\Services\Settings\Settings;

class ServersController extends Controller
{
    public function render(ServersHandler $handler, Settings $settings)
    {
        return new JsonResponse(Status::SUCCESS, [
            'servers' => $handler->servers(),
            'allowLogin' => $settings->get('auth.access_mode')->getValue() === AccessMode::ANY ||
                $settings->get('auth.access_mode')->getValue() === AccessMode::AUTH
        ]);
    }
}
