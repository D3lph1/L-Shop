<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Shop\Payment;

use App\DataTransferObjects\Frontend\Shop\Payer;
use App\DataTransferObjects\Frontend\Shop\Payment;
use App\Exceptions\ForbiddenException;
use App\Exceptions\Purchase\PurchaseNotFoundException;
use App\Repository\Purchase\PurchaseRepository;
use App\Services\Auth\Auth;
use App\Services\Purchasing\Payers\Pool;
use App\Services\Settings\Settings;

class VisitHandler
{
    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var PurchaseRepository
     */
    private $purchaseRepository;

    /**
     * @var Pool
     */
    private $payersPool;

    /**
     * @var Settings
     */
    private $settings;

    public function __construct(
        Auth $auth,
        PurchaseRepository $purchaseRepository,
        Pool $payersPool,
        Settings $settings)
    {
        $this->auth = $auth;
        $this->purchaseRepository = $purchaseRepository;
        $this->payersPool = $payersPool;
        $this->settings = $settings;
    }

    /**
     * @param int $purchaseId
     *
     * @return Payer[]
     *
     * @throws PurchaseNotFoundException
     */
    public function handle(int $purchaseId): array
    {
        $purchase = $this->purchaseRepository->find($purchaseId);
        if ($purchase === null) {
            throw PurchaseNotFoundException::byId($purchaseId);
        }

        if (!$purchase->isAnonymously()) {
            if (!$this->auth->check() || ($this->auth->check() && $this->auth->getUser() !== $purchase->getUser())) {
                throw new ForbiddenException();
            }
        }

        $result = [];

        foreach ($this->payersPool->allEnabled() as $payer) {
            $result[] = new Payer($payer->name(), $payer->paymentUrl($purchase));
        }

        return $result;
    }
}
