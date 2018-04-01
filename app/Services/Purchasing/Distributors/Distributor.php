<?php
declare(strict_types = 1);

namespace App\Services\Purchasing\Distributors;

use App\Entity\Distribution;

/**
 * Interface Distributor
 * Produces the delivery of products to the player.
 */
interface Distributor
{
    /**
     * Produces the delivery of products to the player.
     *
     * @param Distribution $distribution
     */
    public function distribute(Distribution $distribution): void;
}
