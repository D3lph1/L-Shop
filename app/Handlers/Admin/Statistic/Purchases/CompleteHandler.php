<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Statistic\Purchases;

use App\Entity\Purchase;
use App\Exceptions\Purchase\AlreadyCompletedException;
use App\Exceptions\Purchase\DoesNotExistsException;
use App\Repository\Purchase\PurchaseRepository;
use App\Services\Purchasing\PurchaseCompleter;
use App\Services\Purchasing\ViaContext;

class CompleteHandler
{
    /**
     * @var PurchaseRepository
     */
    private $repository;

    /**
     * @var PurchaseCompleter
     */
    private $completer;

    public function __construct(PurchaseRepository $repository, PurchaseCompleter $completer)
    {
        $this->completer = $completer;
        $this->repository = $repository;
    }

    /**
     * @param int $purchaseId The purchase identifier to be completed.
     *
     * @return Purchase
     *
     * @throws DoesNotExistsException If the purchase with the received identifier is not found.
     * @throws AlreadyCompletedException If this purchase is already completed.
     */
    public function handle(int $purchaseId): Purchase
    {
        $purchase = $this->repository->find($purchaseId);
        if ($purchase === null) {
            throw new DoesNotExistsException($purchaseId);
        }

        $this->completer->complete($purchase, ViaContext::BY_ADMIN);

        return $purchase;
    }
}
