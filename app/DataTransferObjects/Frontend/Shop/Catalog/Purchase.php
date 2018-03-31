<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Frontend\Shop\Catalog;

class Purchase
{
    /**
     * @var bool
     */
    private $quick;

    /**
     * @var float
     */
    private $newBalance;

    private $purchaseId;

    public function __construct(bool $isQuick)
    {
        $this->quick = $isQuick;
    }

    public function isQuick(): bool
    {
        return $this->quick;
    }

    public function getNewBalance(): float
    {
        return $this->newBalance;
    }

    public function setNewBalance(float $value): Purchase
    {
        $this->newBalance = $value;

        return $this;
    }

    public function getPurchaseId(): int
    {
        return $this->purchaseId;
    }

    public function setPurchaseId(int $value): Purchase
    {
        $this->purchaseId = $value;

        return $this;
    }
}
