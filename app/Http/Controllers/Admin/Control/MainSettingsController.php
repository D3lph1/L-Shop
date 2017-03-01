<?php

namespace App\Http\Controllers\Admin\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveMainSettingsRequest;

class MainSettingsController extends Controller
{
    /**
     * Render the main settings page
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        $data = [
            'currentServer' => $request->get('currentServer'),
            'shopName' => s_get('shop.name', 'L - Shop'),
            'shopDescription' => s_get('shop.description'),
            'shopKeywords' => s_get('shop.keywords'),
            'isDownForMaintenance' => $this->app->isDownForMaintenance()
        ];

        return view('admin.control.main_settings', $data);
    }

    /**
     * Save main settings options
     *
     * @param SaveMainSettingsRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SaveMainSettingsRequest $request)
    {
        s_set([
            'shop.name' => $request->get('shop_name'),
            'shop.description' => $request->get('shop_description'),
            'shop.keywords' => $request->get('shop_keywords')
        ]);
        s_save();

        $this->maintenance();

        \Message::success('Изменения успешно сохранены!');

        return back();
    }

    public function maintenance()
    {
        if ($this->app->isDownForMaintenance()) {
            \Artisan::call('up');
        }else {
            \Artisan::call('down');
        }
    }
}
