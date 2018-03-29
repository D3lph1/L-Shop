<?php
declare(strict_types = 1);

namespace App\Repository\BalanceTransaction;

use App\Entity\BalanceTransaction;

interface BalanceTransactionRepository
{
    public function create(BalanceTransaction $transaction): void;
}
