<?php
declare(strict_types = 1);

namespace App\Services\Purchasing\Distributors;

use App\Entity\Distribution;

interface Distributor
{
    public function distribute(Distribution $distribution): void;
}
