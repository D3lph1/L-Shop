<?php

namespace App\Http\Controllers\Admin\Control;

use App\Http\Requests\Admin\SaveOptimizationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class OptimizationController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\Control
 */
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
            'currentServer' => $request->get('currentServer'),
            'ttlStatistic' => (int)s_get('caching.statistic.ttl')
        ];

        return view('admin.control.optimization', $data);
    }

    public function save(SaveOptimizationRequest $request)
    {
        s_set([
            'caching.statistic.ttl' => $request->get('ttl_statistic')
        ]);
        s_save();
        \Message::success('Изменения успешно сохранены!');

        return back();
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
