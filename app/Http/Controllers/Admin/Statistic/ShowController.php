<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Statistic;

use App\Http\Controllers\Controller;
use App\TransactionScripts\Statistic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class ShowController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin\Statistic
 */
class ShowController extends Controller
{
    /**
     * @var Statistic
     */
    private $script;

    /**
     * ShowController constructor.
     *
     * @param Statistic $statistic
     */
    public function __construct(Statistic $script)
    {
        parent::__construct();
        $this->script = $script;
    }

    /**
     * Render the "show L-Shop statistic" page.
     */
    public function render(Request $request): View
    {
        $dto = $this->script->statistic($request->get('month'));

        $data = [
            'currentServer' => $request->get('currentServer'),
            'payments' => $dto->getCompletedForYear(),
            'months' => __('content.months'),
            'currentMonth' => $dto->getCurrentMonth(),
            'currentMonthWord' => $dto->getCurrentMonthHumanized(),
            'profit' => $dto->getProfit(),
            'currency' => s_get('shop.currency_html')
        ];

        return view('admin.statistic.show', $data);
    }

    /**
     * Flush all statistic cache.
     */
    public function flushCache(): RedirectResponse
    {
        $this->script->flushCache();
        $this->msg->info(__('messages.admin.statistics.show.clear_cache_success'));

        return back();
    }
}
