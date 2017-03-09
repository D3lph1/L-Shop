<?php

namespace App\Http\Controllers\Admin\Servers;

use App\Http\Requests\Admin\SaveEditedServerRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class EditController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\Servers
 */
class EditController extends Controller
{
    /**
     * Render edit server page
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
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

        $categories = $this->qm->serverCategories($server->first()->id, [
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
        if (mb_strlen($request->get('category')) < 2) {
            \Message::warning('Имя категории не может быть короче 2 символов');
            return json_response('short category name');
        }

        \DB::transaction(function () use ($request) {
            $this->qm->createCategory($request->get('category'), (int)$request->route('edit'));
        });
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
        $editedServer = (int)$request->route('edit');
        $category = (int)$request->get('category');

        if ($this->qm->categoryCount($editedServer) === 1) {
            \Message::warning('Отказано в удалении категории. Должна остаться хотя бы одна категория для данного сервера.');
            return json_response('must stay at least one category');
        }

        \DB::transaction(function () use ($category) {
            $this->qm->removeCategory($category);
        });
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
        $editedServer = $request->route('edit');
        $categories = $request->get('categories');
        \DB::transaction(function () use ($request, $categories, $editedServer) {
            foreach ($categories as $key => $value) {
                $this->qm->updateCategory($key, [
                    'name' => $value[0]
                ]);
            }
            $this->qm->updateServer($editedServer, [
                'name' => $request->get('server_name'),
                'enabled' => (bool)$request->get('enabled')
            ]);
        });
        \Message::success('Изменения успешно сохранены');

        return back();
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeServer(Request $request)
    {
        $removeServerId = $request->route('remove');

        \DB::transaction(function () use ($removeServerId) {
            $this->qm->removeServer($removeServerId);
        });
        \Message::info('Сервер удален');

        return redirect()->route('admin.servers.list', ['server' => $request->get('currentServer')->id]);
    }
}
