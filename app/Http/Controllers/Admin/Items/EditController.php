<?php

namespace App\Http\Controllers\Admin\Items;

use App\Http\Requests\Admin\SaveEditedItemRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        $item = $this->qm->item($request->route('item'), [
            'id',
            'name',
            'image',
            'extra'
        ]);

        if (!$item) {
            \App::abort(404);
        }

        $data = [
            'currentServer' => $request->get('currentServer'),
            'item' => $item
        ];

        return view('admin.items.edit', $data);
    }

    /**
     * @param SaveEditedItemRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SaveEditedItemRequest $request)
    {
        \Message::success('Изменения успешно сохранены');

        return response()->redirectToRoute('admin.items.list', ['server' => $request->get('currentServer')->id]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Request $request)
    {
        $item = (int)$request->route('item');
        $this->qm->removeItem($item);
        \Message::info('Предмет удален');

        return response()->redirectToRoute('admin.items.list', ['server' => $request->get('currentServer')->id]);
    }
}
