<?php
declare(strict_typesr = 1);

namespace App\Repository\PurchaseItem;

interface PurchaseItemRepository
{
    public function retrieveAmountForYearCompleted(): array;

    public function retrieveAmountForMonthCompleted(int $year, int $month): array;

    public function retrieveTopPurchasedProductsCompleted(): array;

    public function retrievePurchasesAmountCompleted(): int;
}
