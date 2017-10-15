<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Control;

use App\Http\Requests\Admin\SaveOptimizationRequest;
use Illuminate\Cache\Repository;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * Class OptimizationController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin\Control
 */
class OptimizationController extends Controller
{
    /**
     * Render the optimization page.
     */
    public function render(Request $request): View
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
     */
    public function save(SaveOptimizationRequest $request): RedirectResponse
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
     */
    public function updateRoutesCache(Kernel $artisan): RedirectResponse
    {
        $artisan->call('route:cache');
        $this->msg->info(__('messages.admin.control.optimization.update_routes_cache_success'));

        return back();
    }

    /**
     * Handle update config cache request.
     */
    public function updateConfigCache(Kernel $artisan): RedirectResponse
    {
        $artisan->call('config:cache');
        $this->msg->info(__('messages.admin.control.optimization.update_config_cache_success'));

        return back();
    }

    /**
     * Handle clear view cache request.
     */
    public function clearViewCache(Kernel $artisan): RedirectResponse
    {
        $artisan->call('view:clear');
        $this->msg->info(__('messages.admin.control.optimization.update_view_cache_success'));

        return back();
    }

    /**
     * Handle clear app cache request.
     */
    public function clearAppCache(Repository $cache): RedirectResponse
    {
        if ($cache->flush()) {
            $this->msg->info(__('messages.admin.control.optimization.update_app_cache_success'));
        } else {
            $this->msg->danger(__('messages.admin.control.optimization.update_app_cache_fail'));
        }

        return back();
    }
}
