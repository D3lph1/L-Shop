<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Other;

use App\Handlers\Admin\Other\Rcon\RenderHandler;
use App\Handlers\Admin\Other\Rcon\SendHandler;
use App\Http\Controllers\Controller;
use App\Services\Auth\Permissions;
use App\Services\Game\Colorizers\HtmlColorizer;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;
use D3lph1\MinecraftRconManager\Exceptions\ConnectSocketException;
use Illuminate\Http\Request;
use function App\permission_middleware;

class RconController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_OTHER_RCON_ACCESS));
    }

    public function render(RenderHandler $handler): JsonResponse
    {
        return new JsonResponse(Status::SUCCESS, [
            'servers' => $handler->handle()
        ]);
    }

    public function send(Request $request, SendHandler $handler, HtmlColorizer $colorizer): JsonResponse
    {
        try {
            return new JsonResponse(Status::SUCCESS, [
                'response' => $colorizer->colorize($handler->handle((int)$request->get('server'), $request->get('command')))
            ]);
        } catch (ConnectSocketException $e) {
            return (new JsonResponse('connection_failed', [
                'response' => $colorizer->red(__('content.admin.other.rcon.connection_failed', [
                    'message' => $e->getMessage()
                ]))
            ]));
        }
    }
}
