<?php

namespace App\Http\Controllers\Admin\Control;

use App\Http\Requests\Admin\SaveOptimizationRequest;
use Illuminate\Filesystem\Filesystem;
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
     * Render the optimization page.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        $data = [
            'currentServer' => $request->get('currentServer'),
            'ttlStatistic' => (int)s_get('caching.statistic.ttl'),
            'ttlStatiсPages' => (int)s_get('caching.pages.ttl'),
            'ttlNews' => (int)s_get('caching.news.ttl'),
            'ttlMonitoring' => (int)s_get('caching.monitoring.ttl')
        ];

        return view('admin.control.optimization', $data);
    }

    /**
     * Handle save optimization settings request.
     *
     * @param SaveOptimizationRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SaveOptimizationRequest $request)
    {
        s_set([
            'caching.statistic.ttl' => $request->get('ttl_statistic'),
            'caching.pages.ttl' => $request->get('ttl_statistic_pages'),
            'caching.news.ttl' => $request->get('ttl_news'),
            'caching.monitoring.ttl' => $request->get('ttl_monitoring')
        ]);
        s_save();
        \Message::success('Изменения успешно сохранены!');

        return back();
    }

    /**
     * Handle update routes cache request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateRoutesCache()
    {
        \Artisan::call('route:cache');
        \Message::info('Кэш маршрутов успешно обновлен');

        return back();
    }

    /**
     * Handle update config cache request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateConfigCache()
    {
        \Artisan::call('config:cache');
        \Message::info('Кэш конфигурации успешно обновлен!');

        return back();
    }

    /**
     * Handle clear view cache request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearViewCache()
    {
        \Artisan::call('view:clear');
        \Message::info('Кэш шаблонизатора успешно очищен!');

        return back();
    }

    /**
     * Handle clear app cache request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearAppCache()
    {
        if (\Cache::flush()) {
            \Message::info('Кэш приложения успешно очищен!');
        } else {
            \Message::danger('Не удалось очистить кэш приложения');
        }

        return back();
    }
}
