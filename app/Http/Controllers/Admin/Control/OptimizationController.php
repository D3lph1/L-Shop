<?php

namespace App\Http\Controllers\Admin\Control;

use App\Http\Requests\Admin\SaveOptimizationRequest;
use Illuminate\Cache\Repository;
use Illuminate\Contracts\Console\Kernel;
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
        $this->msg->success(__('messages.admin.changes_saved'));

        return back();
    }

    /**
     * Handle update routes cache request.
     *
     * @param Kernel $artisan
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateRoutesCache(Kernel $artisan)
    {
        $artisan->call('route:cache');
        $this->msg->info(__('messages.admin.control.optimization.update_routes_cache_success'));

        return back();
    }

    /**
     * Handle update config cache request.
     *
     * @param Kernel $artisan
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateConfigCache(Kernel $artisan)
    {
        $artisan->call('config:cache');
        $this->msg->info(__('messages.admin.control.optimization.update_config_cache_success'));

        return back();
    }

    /**
     * Handle clear view cache request.
     *
     * @param Kernel $artisan
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearViewCache(Kernel $artisan)
    {
        $artisan->call('view:clear');
        $this->msg->info(__('messages.admin.control.optimization.update_view_cache_success'));

        return back();
    }

    /**
     * Handle clear app cache request.
     *
     * @param Repository $cache
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearAppCache(Repository $cache)
    {
        if ($cache->flush()) {
            $this->msg->info(__('messages.admin.control.optimization.update_app_cache_success'));
        } else {
            $this->msg->danger(__('messages.admin.control.optimization.update_app_cache_fail'));
        }

        return back();
    }
}
