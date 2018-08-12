<?php
declare(strict_types = 1);

namespace Tests\Feature\Frontend\Shop;

use App\Entity\Distribution;
use App\Services\Purchasing\Distributors\Distributor;

class MockDistributor implements Distributor
{
    /**
     * @inheritDoc
     */
    public function distribute(Distribution $distribution): void
    {
        //
    }
}
