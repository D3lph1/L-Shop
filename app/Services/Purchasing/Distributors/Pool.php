<?php
declare(strict_types = 1);

namespace App\Services\Purchasing\Distributors;

class Pool
{
    /**
     * @var Distributor[]
     */
    private $distributors;

    /**
     * Pool constructor.
     *
     * @param Distributor[] $distributors
     */
    public function __construct(array $distributors)
    {
        $this->distributors = $distributors;
    }

    public function retrieveByName(string $distributorName): ?Distributor
    {
        foreach ($this->distributors as $distributor) {
            if (get_class($distributor) === $distributorName) {
                return $distributor;
            }
        }

        return null;
    }
}
