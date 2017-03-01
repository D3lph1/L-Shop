<?php

namespace App\Http\Controllers\Admin\Control;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OptimizationController extends Controller
{
    /**
     * Render the optimization page
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        $data = [
            'currentServer' => $request->get('currentServer')
        ];

        return view('admin.control.optimization', $data);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateRoutesCache()
    {
        \Artisan::call('route:cache');
        \Message::info('Кэш маршрутов успешно обновлен');

        return back();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateConfigCache()
    {
        \Artisan::call('config:cache');
        \Message::info('Кэш конфигурации успешно обновлен!');

        return back();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearViewCache()
    {
        \Artisan::call('view:clear');
        \Message::info('Кэш шаблонизатора успешно очищен!');

        return back();
    }
}
