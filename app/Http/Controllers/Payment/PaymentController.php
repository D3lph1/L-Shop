<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Payment;

use App\Exceptions\LogicException;
use App\Exceptions\Payment\AlreadyCompletedException;
use App\Exceptions\Payment\NotFoundException;
use App\Http\Controllers\Controller;
use App\Models\Payment\PaymentInterface;
use App\TransactionScripts\Payments;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class PaymentController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Payment
 */
class PaymentController extends Controller
{
    /**
     * @var PaymentInterface
     */
    private $payment;

    /**
     * Render the payment methods page
     */
    public function render(Request $request, Payments $script): View
    {
        $methods = null;

        try {
            $methods = $script->methods((int)$request->route('payment'));
        } catch (NotFoundException $e) {
            $this->app->abort(404);
        } catch (AlreadyCompletedException | LogicException $e) {
            $this->app->abort(403);
        }

        return view('payment.methods', [
            'methods' => $methods
        ]);
    }

    public function renderFillUpBalancePage(): View
    {
        return view('payment.fillupbalance');
    }

    public function fillUpBalance(Request $request, Payments $script): JsonResponse
    {
        $sum = (float)$request->get('sum');
        $validated = $this->validateFillUpBalanceSum($sum, true);

        if ($validated !== true) {
            return $validated;
        }

        $payment = $script->fillupbalance(
            $this->sentinel->getUser()->getId(),
            $sum,
            (int)$request->route('server'),
            $request->ip()
        );

        return json_response('success',[
                'redirect' => route('payment.methods', [
                'server' => $request->get('currentServer')->getId(),
                'payment' => $payment
            ])
        ]);
    }
}
