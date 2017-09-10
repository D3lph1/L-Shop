<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Other;

use D3lph1\MinecraftRconManager\Connector;
use D3lph1\MinecraftRconManager\Exceptions\ConnectSocketException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\View\View;

/**
 * Class RconController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin\Other
 */
class RconController extends Controller
{
    public function render(Request $request): View
    {
        /** @var Collection $servers */
        $servers = $request->get('servers');
        $selected = (int) $request->get('selected');

        $searched = $servers->filter(function ($item) use ($selected) {
            return $item->id === $selected;
        });

        $data = [
            'searched' => $searched,
            'currentServer' => $request->get('currentServer'),
            'servers' => $servers
        ];

        return view('admin.other.rcon', $data);
    }

    public function send(Request $request, Connector $rconConnector): JsonResponse
    {
        $server = (int) $request->route('send');
        $cmd = $request->get('cmd');

        try {
            $rcon = $rconConnector->get($server);
        } catch (ConnectSocketException $e) {
            /** @var Collection $servers */
            $servers = $request->get('servers');
            $filtered = $servers->filter(function ($item) use ($server) {
                return $item->id === $server;
            });

            return json_response('connect error', [
                'host' => $filtered->first()->ip,
                'port' => $filtered->first()->port
            ]);
        }
        $result = $rcon->send($cmd);
        $result = str_replace("\n", '<br>', $result);

        if ($request->get('colorize')) {
            $result = colorize_rcon($result);
        }

        $rcon->disconnect();

        return json_response('success', compact('result'));
    }
}
