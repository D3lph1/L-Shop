<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin\Servers;

use App\DataTransferObjects\Category;
use App\DataTransferObjects\Server;
use App\Exceptions\Server\AttemptToDeleteTheLastCategoryException;
use App\Exceptions\Server\AttemptToDeleteTheLastServerException;
use App\Exceptions\Server\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveEditedServerRequest;
use App\TransactionScripts\Servers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class EditController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin\Server
 */
class EditController extends Controller
{
    /**
     * @var Servers
     */
    private $script;

    public function __construct(Servers $script)
    {
        parent::__construct();
        $this->script = $script;
    }

    /**
     * Render edit server page.
     */
    public function render(Request $request, Servers $script): View
    {
        $dto = null;

        try {
            $dto = $script->informationForEdit((int)$request->route('edit'), $request->get('servers'));
        } catch (NotFoundException $e) {
            $this->app->abort(404);
        }

        return view('admin.servers.edit', [
            'currentServer' => $request->get('currentServer'),
            'server' => $dto->getServer(),
            'categories' => $dto->getCategories()
        ]);
    }

    public function addCategory(Request $request): JsonResponse
    {
        $category = (new Category())
            ->setName($request->get('category'))
            ->setServerId((int)$request->route('edit'));

        // TODO: Make response for failure situation.
        if ($this->script->createCategory($category)) {
            $this->msg->success(__('messages.admin.servers.add.category.add.success', ['name' => $category->getName()]));

            return json_response('success');
        }

        return json_response('fail');
    }

    public function removeCategory(Request $request): JsonResponse
    {
        $serverId = (int)$request->route('edit');
        $categoryId = (int)$request->get('category');

        try {
            $result = $this->script->removeCategory($categoryId, $serverId);
        } catch (AttemptToDeleteTheLastCategoryException $e) {
            $this->msg->warning(__('messages.admin.servers.add.category.remove.last'));

            return json_response('must stay at least one category');
        }

        // TODO: Make response for failure situation.
        if ($result) {
            $this->msg->info(__('messages.admin.servers.add.category.remove.success'));

            return json_response('success');
        }

        return json_response('fail');
    }

    public function save(SaveEditedServerRequest $request): RedirectResponse
    {
        // $request->get('categories') contains array:
        // [
        //      {category_id} => [
        //          0 => {category_name}
        //      ],
        //      5 => [
        //          0 => "Example of category name"
        //      ]
        // ]

        $categories = [];
        foreach ($request->get('categories') as $key => $category) {
            $t = (new Category())
                ->setId($key)
                ->setName($category[0])
                ->setServerId((int)$request->route('edit'));
            $categories[] = $t;
        }

        $dto = (new Server())
            ->setId((int)$request->route('edit'))
            ->setName($request->get('server_name'))
            ->setEnabled((bool)$request->get('enabled'))
            ->setCategories($categories)
            ->setIp($request->get('server_ip'))
            ->setPort((int)$request->get('server_port'))
            ->setPassword($request->get('server_password'))
            ->setMonitoringEnabled((bool)$request->get('server_monitoring_enabled'));

        $this->script->updateServer($dto);
        $this->msg->success(__('messages.admin.changes_saved'));

        return back();
    }

    /**
     * Attempt to delete given server with categories
     */
    public function removeServer(Request $request): RedirectResponse
    {
        $serverId = (int)$request->route('remove');

        try {
            $this->script->removeServer($serverId);
        } catch (AttemptToDeleteTheLastServerException $e) {
            $this->msg->warning(__('messages.admin.servers.remove.last'));

            return redirect()->route('admin.servers.list', $request->get('currentServer')->id);
        }

        $this->msg->info(__('messages.admin.servers.remove.success'));

        return redirect()->route('servers');
    }
}
