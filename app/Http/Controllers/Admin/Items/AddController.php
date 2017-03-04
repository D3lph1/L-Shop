<?php

namespace App\Http\Controllers\Admin\Items;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveAddedItemRequest;
use Illuminate\Http\UploadedFile;

class AddController extends Controller
{
    public function render(Request $request)
    {
        $data = [
            'currentServer' => $request->get('currentServer')
        ];

        return view('admin.items.add', $data);
    }

    public function save(SaveAddedItemRequest $request)
    {
        $image = $request->file('image');
        $filename = null;
        if ($image) {
            $filename = $this->moveImageAndGetName($image);
        }

        \DB::transaction(function () use ($request, $filename){
            $this->qm->createItem([
                'name' => $request->get('name'),
                'description' => '',
                'type' => 'item',
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
