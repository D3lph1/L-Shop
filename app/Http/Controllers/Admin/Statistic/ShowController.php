<?php

namespace App\Http\Controllers\Admin\Statistic;

use App\Services\Statistic;
use Carbon\Carbon;
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
     * @var array
     */
    protected $months = [
        1 => 'Январь',
        2 => 'Февраль',
        3 => 'Март',
        4 => 'Апрель',
        5 => 'Май',
        6 => 'Июнь',
        7 => 'Июль',
        8 => 'Август',
        9 => 'Сентябрь',
        10 => 'Октябрь',
        11 => 'Ноябрь',
        12 => 'Декабрь'
    ];

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
            'months' => $this->months,
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function flushCache()
    {
        \Cache::forget('admin.statistic.for_the_last_year_completed');
        \Cache::forget('admin.statistic.profit');
        \Message::info('Кэш статистики очищен!');

        return back();
    }
}
