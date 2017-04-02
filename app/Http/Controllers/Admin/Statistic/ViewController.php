<?php

namespace App\Http\Controllers\Admin\Statistic;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewController extends Controller
{
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

    public function render(Request $request)
    {
        $payments = $this->qm->paymentsForStatisticOrdersCount();

        $currentMonth = $request->get('month') ?: (new \DateTime())->format('n');

        $currentMonthWord = new Carbon();
        $currentMonthWord->month = $currentMonth;
        $currentMonthWord = humanize_month($currentMonthWord->formatLocalized('%B'));

        $profit = $this->qm->profitForStatistic();

        $data = [
            'currentServer' => $request->get('currentServer'),
            'payments' => $payments,
            'months' => $this->months,
            'currentMonth' => $currentMonth,
            'currentMonthWord' => $currentMonthWord,
            'profit' => $profit,
            'currency' => s_get('shop.currency_html')
        ];

        return view('admin.statistic.view', $data);
    }
}
