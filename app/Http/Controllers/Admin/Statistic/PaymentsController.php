<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Statistic;

use App\Exceptions\Payment\AlreadyCompletedException;
use App\Exceptions\Payment\NotFoundException;
use App\Http\Controllers\Controller;
use App\TransactionScripts\Payments;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class PaymentsController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin\Statistic
 */
class PaymentsController extends Controller
{
    private $script;

    public function __construct(Payments $script)
    {
        parent::__construct();
        $this->script = $script;
    }

    /**
     * Render the payments list page.
     */
    public function render(Request $request): View
    {
        return view('admin.statistic.payments', [
            'servers' => $request->get('servers'),
            'payments' => $this->script->informationForList(),
            'currency' => s_get('shop.currency_html')
        ]);
    }

    /**
     * Get detail information about concrete payment.
     */
    public function info(Request $request): JsonResponse
    {
        try {
            return json_response('success', [
                'products' => $this->script->informationForHistory((int)$request->route('payment'))
            ]);
        } catch (NotFoundException $e) {
            return json_response('payment not found');
        }
    }

    /**
     * Complete given payment request.
     */
    public function complete(Request $request): RedirectResponse
    {
        try {
            $this->script->complete((int)$request->route('payment'));
        } catch (NotFoundException $e) {
            $this->msg->danger(__('messages.admin.statistics.payments.complete.not_found'));
        } catch (AlreadyCompletedException $e) {
            $this->msg->warning(__('messages.admin.statistics.payments.complete.already_complete'));
        }

        $this->msg->success(__('messages.admin.statistics.payments.complete.success'));

        return back();
    }
}
