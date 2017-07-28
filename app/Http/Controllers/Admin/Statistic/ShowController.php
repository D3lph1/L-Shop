<?php

namespace App\Http\Controllers\Admin\Statistic;

use App\Services\Statistic;
use Carbon\Carbon;
use Illuminate\Cache\Repository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class ShowController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\Statistic
 */
class ShowController extends Controller
{
    /**
     * @var Statistic
     */
    private $statistic;

    /**
     * ShowController constructor.
     *
     * @param Statistic $statistic
     */
    public function __construct(Statistic $statistic)
    {
        $this->statistic = $statistic;
        parent::__construct();
    }

    /**
     * Render the "show L-Shop statistic" page.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        $payments = $this->statistic->forTheLastYearCompleted();

        $currentMonth = $request->get('month') ?: (new \DateTime())->format('n');

        $currentMonthWord = new Carbon();
        $currentMonthWord->month = $currentMonth;
        $currentMonthWord = humanize_month($currentMonthWord->formatLocalized('%B'));

        $profit = $this->statistic->profit();

        $data = [
            'currentServer' => $request->get('currentServer'),
            'payments' => $payments,
            'months' => __('content.months'),
            'currentMonth' => $currentMonth,
            'currentMonthWord' => $currentMonthWord,
            'profit' => $profit,
            'currency' => s_get('shop.currency_html')
        ];

        return view('admin.statistic.show', $data);
    }

    /**
     * Flush all statistic cache.
     *
     * @param Repository $cache
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function flushCache(Repository $cache)
    {
        $cache->forget('admin.statistic.for_the_last_year_completed');
        $cache->forget('admin.statistic.profit');
        $this->msg->info(__('messages.admin.statistics.show.clear_cache_success'));

        return back();
    }
}
