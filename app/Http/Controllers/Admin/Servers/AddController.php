<?php

namespace App\Http\Controllers\Admin\Servers;

use App\Http\Requests\Admin\SaveAddedServerRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class AddController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\Servers
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

        return view('admin.servers.add', $data);
    }

    /**
     * @param SaveAddedServerRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SaveAddedServerRequest $request)
    {
        \DB::transaction(function () use ($request) {
            $id = $this->qm->createServer([
                'name' => $request->get('server_name'),
                'enabled' => (bool)$request->get('enabled'),
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

            $query = [];
            foreach ($request->get('categories') as $category) {
                $query[] = [
                    'name' => $category,
                    'server_id' => $id,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString()
                ];
            }

            $this->qm->createCategories($query);
        });
        \Message::success("Сервер \"{$request->get('server_name')}\" успешно создан");

        return response()->redirectToRoute('admin.servers.list', [
            'server' => $request->get('currentServer')->id
        ]);
    }
}
