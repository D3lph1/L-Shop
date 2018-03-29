<?php
declare(strict_types = 1);

namespace App\Repository\Distribution;

use App\Entity\Distribution;

interface DistributionRepository
{
    public function create(Distribution $distribution): void;
}
