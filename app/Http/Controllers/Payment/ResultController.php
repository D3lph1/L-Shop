<?php

namespace App\Http\Controllers\Payment;

use App\Exceptions\FailedToUpdateTableException;
use App\Exceptions\Payment\AlreadyCompleteException;
use App\Exceptions\Payment\NotFoundException;
use App\Exceptions\Payment\UnableToCompleteException;
use App\Services\Handlers\Payments\AbstractPayment;
use App\Services\Handlers\Payments\Robokassa;
use App\Services\QueryManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class ResultController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Payment
 */
class ResultController extends Controller
{
    /**
     * Handle request payment request from robokassa service
     *
     * @param Request   $request
     * @param Robokassa $handler
     *
     * @return \Illuminate\Http\Response
     */
    public function robokassa(Request $request, Robokassa $handler)
    {
        return $this->handle($request->all(), $handler);
    }

    /**
     * @param array           $all
     * @param AbstractPayment $handler
     *
     * @return \Illuminate\Http\Response
     */
    private function handle(array $all, AbstractPayment $handler)
    {
        $result = null;

        try {
            $result = $handler->handle($all, false);
        } catch (NotFoundException $e) {
            \Log::warning($e);

            return response()->make('Payment not found', 404);
        } catch (AlreadyCompleteException $e) {
            \Log::warning($e);

            return response()->make('Already complete', 400);
        } catch (UnableToCompleteException $e) {
            \Log::warning($e);

            return response()->make('Unable to complete payment', 400);
        }

        return $result ? response()->make($result, 200) : response()->make('Failed', 400);
    }
}
