<?php
declare(strict_types = 1);

namespace App\Repository\Item;

interface ItemRepository
{
    public function deleteAll(): bool;
}
