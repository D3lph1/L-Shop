<?php

namespace App\Http\Controllers\Admin\Items;

use App\Http\Requests\Admin\SaveEditedItemRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;

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
            'item',
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
        $image = $request->file('image');
        $filename = null;
        if ($image) {
            $filename = $this->moveImageAndGetName($image);
        }

        \DB::transaction(function () use ($request, $filename) {
            $this->qm->updateItem((int)$request->route('item'), [
                'name' => $request->get('name'),
                'item' => $request->get('item'),
                'extra' => $request->get('extra'),
                'image' => $filename
            ]);
        });
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

    /**
     * @param UploadedFile $file
     *
     * @return string
     */
    private function moveImageAndGetName(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $md5 = md5_file(sys_get_temp_dir() . DIRECTORY_SEPARATOR . $file->getFilename());
        $filename = $md5 . '.' . $extension;
        $file->move(public_path('img/items'), $filename);
        return $filename;
    }
}
