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
            'accessMode' => s_get('shop.access_mode'),
            'enableSignup' => s_get('shop.enable_signup'),
            'enableEmailActivation' => s_get('auth.email_activation'),
            'productsPerPage' => s_get('catalog.products_per_page'),
            'cartCapacity' => s_get('cart.capacity'),
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
            'shop.keywords' => $request->get('shop_keywords'),
            'shop.access_mode' => $request->get('access_mode'),
            'shop.enable_signup' => (bool)$request->get('enable_signup'),
            'auth.email_activation' => (bool)$request->get('enable_email_activation'),
            'catalog.products_per_page' => $request->get('products_per_page'),
            'cart.capacity' => $request->get('cart_capacity')
        ]);
        s_save();

        $this->maintenance((bool)$request->get('maintenance'));

        \Message::success('Изменения успешно сохранены!');

        return back();
    }

    public function maintenance($maintenance)
    {
        if ($maintenance) {
            \Artisan::call('down');
        }else {
            \Artisan::call('up');
        }
    }
}
