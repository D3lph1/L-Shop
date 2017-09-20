<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Servers;

use App\DataTransferObjects\Category;
use App\DataTransferObjects\Server;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveAddedServerRequest;
use App\TransactionScripts\Servers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class AddController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin\Server
 */
class AddController extends Controller
{
    /**
     * Render the add new server page
     */
    public function render(Request $request): View
    {
        return view('admin.servers.add', [
            'currentServer' => $request->get('currentServer')
        ]);
    }

    public function save(SaveAddedServerRequest $request, Servers $script): RedirectResponse
    {
        $categories = [];
        foreach ($request->get('categories') as $category) {
            $categories[] = (new Category())->setName($category);
        }

        $dto = (new Server())
            ->setName($request->get('server_name'))
            ->setCategories($categories)
            ->setIp($request->get('server_ip'))
            ->setPort((int)$request->get('server_port'))
            ->setPassword($request->get('server_password'))
            ->setMonitoringEnabled((bool)$request->get('server_monitoring_enabled'));

        $script->createServer($dto);

        $this->msg->success(__('messages.admin.servers.add.success', ['name' => $request->get('server_name')]));

        return response()->redirectToRoute('admin.servers.list', [
            'server' => $request->get('currentServer')->getId()
        ]);
    }
}
