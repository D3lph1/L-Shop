<?php
declare(strict_types = 1);

namespace App\Repository\ShoppingCart;

use App\Entity\ShoppingCart;

interface ShoppingCartRepository
{
    public function create(ShoppingCart $shoppingCart): void;
}
