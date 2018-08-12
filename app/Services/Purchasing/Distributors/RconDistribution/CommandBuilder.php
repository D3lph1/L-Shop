<?php
declare(strict_types = 1);

namespace App\Services\Purchasing\Distributors\RconDistribution;

use App\Entity\PurchaseItem;

interface CommandBuilder
{
    /**
     * Builds commands for execution.
     *
     * @param PurchaseItem $purchaseItem
     *
     * @return ExecutableCommands
     */
    public function build(PurchaseItem $purchaseItem): ExecutableCommands;
}
