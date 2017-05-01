<?php

namespace App\Http\Controllers\Admin\Servers;

use App\Http\Requests\Admin\SaveAddedServerRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class AddController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\Servers
 */
class AddController extends BaseController
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        $data = [
            'currentServer' => $request->get('currentServer')
        ];

        return view('admin.servers.add', $data);
    }

    /**
     * @param SaveAddedServerRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SaveAddedServerRequest $request)
    {
        $name = $request->get('server_name');
        $enabled = (bool)$request->get('enabled');
        $categories = $request->get('categories');

        // ~~~~~~~~~~ MAIN METHOD ~~~~~~~~~~ //
        $this->serverService->createServer($name, $enabled, $categories);

        \Message::success("Сервер \"{$request->get('server_name')}\" успешно создан");

        return response()->redirectToRoute('admin.servers.list', [
            'server' => $request->get('currentServer')->id
        ]);
    }
}
