<?php

namespace App\Http\Controllers\Admin\Items;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveAddedItemRequest;
use Illuminate\Http\UploadedFile;

/**
 * Class AddController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\Items
 */
class AddController extends Controller
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

        return view('admin.items.add', $data);
    }

    /**
     * @param SaveAddedItemRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SaveAddedItemRequest $request)
    {
        $itemType = $request->get('item_type');
        $image = $request->file('image');
        $filename = null;
        if ($image) {
            $filename = $this->moveImageAndGetName($image);
        }

        \DB::transaction(function () use ($request, $filename, $itemType){
            $this->qm->createItem([
                'name' => $request->get('name'),
                'description' => '',
                'type' => $itemType == 'item' ? 'item' : 'permgroup',
                'image' => $filename,
                'item' => $request->get('item'),
                'extra' => $request->get('extra'),
                'created_at' => Carbon::now()->toDateTimeString()
            ]);
        });

        \Message::success('Предмет создан успешно');

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
