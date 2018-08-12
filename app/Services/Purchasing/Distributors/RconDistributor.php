<?php
declare(strict_types = 1);

namespace App\Services\Purchasing\Distributors;

use App\Entity\Distribution;
use App\Jobs\Purchasing\Distribution\DistributeByRcon;
use App\Services\Purchasing\Distributors\RconDistribution\CommandBuilder;
use Illuminate\Contracts\Bus\Dispatcher;

/**
 * Class RconDistributor
 * Produces the delivery of products by RCON protocol.
 *
 * @see http://wiki.vg/RCON
 */
class RconDistributor implements Distributor, Attempting
{
    /**
     * @var CommandBuilder
     */
    private $commandBuilder;

    /**
     * @var Dispatcher
     */
    private $dispatcher;

    public function __construct(
        CommandBuilder $commandBuilder,
        Dispatcher $dispatcher)
    {
        $this->commandBuilder = $commandBuilder;
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritDoc}
     */
    public function distribute(Distribution $distribution): void
    {
        $commands = $this->commandBuilder->build($distribution->getPurchaseItem());
        $this->dispatcher->dispatch(new DistributeByRcon(
            $distribution,
            $commands
        ));
    }
}
