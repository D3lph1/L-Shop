<?php

namespace App\Http\Controllers\Admin\Servers;

use App\DataTransferObjects\Admin\Category;
use App\DataTransferObjects\Admin\Server;
use App\Exceptions\Server\AttemptToDeleteTheLastCategoryException;
use App\Exceptions\Server\AttemptToDeleteTheLastServerException;
use App\Http\Requests\Admin\SaveEditedServerRequest;
use App\Repositories\ServerRepository;
use Illuminate\Http\Request;

/**
 * Class EditController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\Server
 */
class EditController extends BaseController
{
    /**
     * Render edit server page.
     *
     * @param Request          $request
     * @param ServerRepository $serverRepository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request, ServerRepository $serverRepository)
    {
        $server = null;
        foreach ($request->get('servers') as $s) {
            if ($s->id == $request->route('edit')) {
                $server = collect([$s]);
                break;
            }
        }

        if (!$server) {
            $this->app->abort(404);
        }

        $categories = $serverRepository->categories($server->first()->id, [
            'id',
            'name'
        ]);

        $data = [
            'currentServer' => $request->get('currentServer'),
            'server' => $server->first(),
            'categories' => $categories
        ];

        return view('admin.servers.edit', $data);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCategory(Request $request)
    {
        $category = new Category($request->get('category'));
        $category->setServerId($request->route('edit'));

        $this->serverService->createCategory($category);

        $this->msg->success(__('messages.admin.servers.add.category.add.success', ['name' => $category->getName()]));

        return json_response('success');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeCategory(Request $request)
    {
        $serverId = (int)$request->route('edit');
        $categoryId = (int)$request->get('category');

        try {
            $this->serverService->removeCategory($serverId, $categoryId);
        } catch (AttemptToDeleteTheLastCategoryException $e) {
            $this->msg->warning(__('messages.admin.servers.add.category.remove.last'));

            return json_response('must stay at least one category');
        }

        $this->msg->info(__('messages.admin.servers.add.category.remove.success'));

        return json_response('success');
    }

    /**
     * @param SaveEditedServerRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SaveEditedServerRequest $request)
    {
        $categories = [];
        foreach ($request->get('categories') as $key => $category) {
            $t = new Category($category[0]);
            $t->setId($key);
            $categories[] = $t;
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
        $dto->setId($request->route('edit'));

        $this->serverService->updateServer($dto);
        $this->msg->success(__('messages.admin.changes_saved'));

        return back();
    }

    /**
     * Attempt to delete given server with categories
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeServer(Request $request)
    {
        $serverId = (int)$request->route('remove');

        try {
            $this->serverService->removeServer($serverId);
        }catch (AttemptToDeleteTheLastServerException $e) {
            $this->msg->warning(__('messages.admin.servers.remove.last'));

            return redirect()->route('admin.servers.list', $request->get('currentServer')->id);
        }

        $this->msg->info(__('messages.admin.servers.remove.success'));

        return redirect()->route('servers');
    }
}
