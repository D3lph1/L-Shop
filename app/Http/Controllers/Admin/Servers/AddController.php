<?php

namespace App\Http\Controllers\Admin\Servers;

use App\DataTransferObjects\Admin\Category;
use App\DataTransferObjects\Admin\Server;
use App\Http\Requests\Admin\SaveAddedServerRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class AddController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\Server
 */
class AddController extends BaseController
{
    /**
     * Render the add new server page
     *
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
        $categories = [];
        foreach ($request->get('categories') as $category) {
            $categories[] = new Category($category);
        }

        $dto = new Server(
            $request->get('server_name'),
            $request->get('enabled'),
            $categories,
            $request->get('server_ip'),
            $request->get('server_port'),
            $request->get('server_password'),
            $request->get('server_monitoring_enabled')
        );

        $this->serverService->createServer($dto);

        $this->msg->success(__('messages.admin.servers.add.success', ['name' => $request->get('server_name')]));

        return response()->redirectToRoute('admin.servers.list', [
            'server' => $request->get('currentServer')->id
        ]);
    }
}
