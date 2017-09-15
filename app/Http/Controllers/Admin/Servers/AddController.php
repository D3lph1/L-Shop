<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Servers;

use App\DataTransferObjects\Category;
use App\DataTransferObjects\Server;
use App\Http\Requests\Admin\SaveAddedServerRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class AddController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin\Server
 */
class AddController extends BaseController
{
    /**
     * Render the add new server page
     */
    public function render(Request $request): View
    {
        $data = [
            'currentServer' => $request->get('currentServer')
        ];

        return view('admin.servers.add', $data);
    }

    public function save(SaveAddedServerRequest $request): RedirectResponse
    {
        $categories = [];
        foreach ($request->get('categories') as $category) {
            $categories[] = new Category($category);
        }

        $dto = (new Server())
            ->setName($request->get('server_name'))
            ->setCategories($categories)
            ->setIp($request->get('server_ip'))
            ->setPort($request->get('server_port'))
            ->setPassword($request->get('server_password'))
            ->setMonitoringEnabled($request->get('server_monitoring_enabled'));

        $this->serverService->createServer($dto);

        $this->msg->success(__('messages.admin.servers.add.success', ['name' => $request->get('server_name')]));

        return response()->redirectToRoute('admin.servers.list', [
            'server' => $request->get('currentServer')->id
        ]);
    }
}
