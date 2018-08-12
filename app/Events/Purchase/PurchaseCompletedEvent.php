<?php
declare(strict_types = 1);

namespace App\Events\Purchase;

use App\Entity\Purchase;

class PurchaseCompletedEvent
{
    /**
     * @var Purchase
     */
    private $purchase;

    public function __construct(Purchase $purchase)
    {
        $this->purchase = $purchase;
    }

    public function getPurchase(): Purchase
    {
        return $this->purchase;
    }
}
