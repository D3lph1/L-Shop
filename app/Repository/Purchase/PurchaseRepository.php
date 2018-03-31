<?php
declare(strict_types = 1);

namespace App\Repository\Purchase;

use App\Entity\Purchase;

interface PurchaseRepository
{
    public function create(Purchase $purchase): void;

    public function find(int $id): ?Purchase;

    public function deleteAll(): bool;
}
