<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Repositories\PaymentRepository;
use App\Repositories\ProductRepository;
use App\TransactionScripts\Payments;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class PaymentsController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Profile
 */
class PaymentsController extends Controller
{
    /**
     * Render the profile payments history page.
     */
    public function render(Request $request, Payments $script): View
    {
        $data = [
            'servers' => $request->get('servers'),
            'payments' => $script->informationForUser($this->sentinel->getUser()->getId())
        ];

        return view('profile.payments', $data);
    }

    /**
     * Get more information about given payment.
     */
    public function info(Request $request, Payments $script): JsonResponse
    {
        return json_response('success', [
            'products' => $script->informationForHistory((int)$request->route('payment'))
        ]);
    }
}
