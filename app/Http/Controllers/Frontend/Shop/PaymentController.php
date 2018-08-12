<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Shop;

use App\Exceptions\Payer\InvalidPaymentDataException;
use App\Exceptions\Payer\PayerNotFoundException;
use App\Exceptions\Purchase\AlreadyCompletedException;
use App\Exceptions\Purchase\PurchaseNotFoundException;
use App\Handlers\Frontend\Shop\Payment\ResultHandler;
use App\Http\Controllers\Controller;
use App\Services\Notification\Notifications\Info;
use App\Services\Notification\Notifications\Success;
use App\Services\Notification\Notificator;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymentController extends Controller
{
    public function result(Request $request, ResultHandler $handler): Response
    {
        try {
            $response = $handler->handle((string)$request->route('payer'), $request->all());

            return new Response($response);
        } catch (PayerNotFoundException $e) {
            return new Response('Payer not found', Response::HTTP_NOT_FOUND);
        } catch (InvalidPaymentDataException $e) {
            return new Response('Invalid payment data', Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (PurchaseNotFoundException $e) {
            return new Response($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (AlreadyCompletedException $e) {
            return new Response('Purchase already completed', Response::HTTP_CONFLICT);
        }
    }

    public function wait(Repository $config, Notificator $notificator): RedirectResponse
    {
        $notificator->notify(new Info(__('msg.frontend.shop.payment.wait')));

        return new RedirectResponse($config->get('app.url'));
    }

    public function success(Repository $config, Notificator $notificator): RedirectResponse
    {
        $notificator->notify(new Success(__('msg.frontend.shop.payment.success')));

        return new RedirectResponse($config->get('app.url'));
    }

    public function fail(Repository $config, Notificator $notificator): RedirectResponse
    {
        $notificator->notify(new Info(__('msg.frontend.shop.payment.error')));

        return new RedirectResponse($config->get('app.url'));
    }
}
