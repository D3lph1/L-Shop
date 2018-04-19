<?php
declare(strict_types = 1);

namespace App\Services\Purchasing;

use App\Entity\Distribution;
use App\Entity\Purchase;
use App\Exceptions\Purchase\AlreadyCompletedException;
use App\Repository\Distribution\DistributionRepository;
use App\Repository\Purchase\PurchaseRepository;
use App\Services\Purchasing\Distributors\Distributor;
use App\Services\User\Balance\Transactor;

class PurchaseCompleter
{
    /**
     * @var PurchaseRepository
     */
    private $purchaseRepository;

    /**
     * @var Distributor
     */
    private $distributor;

    /**
     * @var DistributionRepository
     */
    private $distributionRepository;

    /**
     * @var Transactor
     */
    private $transactor;

    public function __construct(
        PurchaseRepository $purchaseRepository,
        Distributor $distributor,
        DistributionRepository $distributionRepository,
        Transactor $transactor)
    {
        $this->purchaseRepository = $purchaseRepository;
        $this->distributor = $distributor;
        $this->distributionRepository = $distributionRepository;
        $this->transactor = $transactor;
    }

    /**
     * Completes the purchase received and issues the products/shop currency to the player.
     *
     * @param Purchase    $purchase
     *
     * @param null|string $via Specifies the context in which the purchase was completed.
     *
     * @AlreadyCompletedException If the purchase has already been completed.
     * @throws \Exception
     */
    public function complete(Purchase $purchase, ?string $via = null): void
    {
        if ($purchase->isCompleted()) {
            throw new AlreadyCompletedException($purchase);
        }

        $purchase->setCompletedAt(new \DateTimeImmutable());
        $purchase->setVia($via);
        $this->purchaseRepository->update($purchase);

        if (count($purchase->getItems()) !== 0) {
            foreach ($purchase->getItems() as $purchaseItem) {
                $distribution = new Distribution($purchaseItem);
                $this->distributionRepository->create($distribution);
                $this->distributor->distribute($distribution);
            }
        } else {
            $this->transactor->add($purchase->getUser(), $purchase->getCost());
        }
    }
}
