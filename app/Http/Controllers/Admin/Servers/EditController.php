<?php

namespace App\Http\Controllers\Admin\Servers;

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
            \App::abort(404);
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
        $name = $request->get('category');
        $serverId = (int)$request->route('edit');

        // ~~~~~~~~~~ MAIN METHOD ~~~~~~~~~~ //
        $this->serverService->createCategory($serverId, $name);

        \Message::success("Категория \"{$request->get('category')}\" создана");

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
            // ~~~~~~~~~~ MAIN METHOD ~~~~~~~~~~ //
            $this->serverService->removeCategory($serverId, $categoryId);
        } catch (AttemptToDeleteTheLastCategoryException $e) {
            \Message::warning('Должна остаться хотя бы одна категория для данного сервера.');

            return json_response('must stay at least one category');
        }

        \Message::info('Категория удалена');

        return json_response('success');
    }

    /**
     * @param SaveEditedServerRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SaveEditedServerRequest $request)
    {
        $serverId = (int)$request->route('edit');
        $name = $request->get('server_name');
        $enabled = (bool)$request->get('enabled');
        $categories = $request->get('categories');
        $ip = $request->get('server_ip');
        $port = $request->get('server_port');
        $password = $request->get('server_password');
        $monitoringEnabled = (bool)$request->get('server_monitoring_enabled');

        // ~~~~~~~~~~ MAIN METHOD ~~~~~~~~~~ //
        $this->serverService->updateServer($serverId, $name, $enabled, $categories, $ip, $port, $password, $monitoringEnabled);

        \Message::success('Изменения успешно сохранены.');

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
            // ~~~~~~~~~~ MAIN METHOD ~~~~~~~~~~ //
            $this->serverService->removeServer($serverId);
        }catch (AttemptToDeleteTheLastServerException $e) {
            \Message::warning('Удалить последний сервер невозможно!');

            return redirect()->route('admin.servers.list', $request->get('currentServer')->id);
        }

        \Message::info('Сервер удален.');

        return redirect()->route('servers');
    }
}
