<?php
declare(strict_types = 1);

namespace App\Services\Purchasing\Distributors;

use App\Entity\Distribution;
use App\Jobs\Purchasing\Distribution\DistributeByRcon;
use App\Services\Purchasing\Distributors\RconDistribution\CommandBuilder;
use App\Services\Purchasing\Distributors\RconDistribution\ExtraCommands;
use Illuminate\Contracts\Bus\Dispatcher;

class RconDistributor implements Distributor, Attempting
{
    /**
     * @var CommandBuilder
     */
    private $commandBuilder;

    /**
     * @var ExtraCommands
     */
    private $extraCommands;

    /**
     * @var string
     */
    private $successResponse;

    /**
     * @var Dispatcher
     */
    private $dispatcher;

    public function __construct(
        CommandBuilder $commandBuilder,
        ExtraCommands $extraCommands,
        string $successResponse,
        Dispatcher $dispatcher)
    {
        $this->commandBuilder = $commandBuilder;
        $this->successResponse = $successResponse;
        $this->dispatcher = $dispatcher;
        $this->extraCommands = $extraCommands;
    }

    /**
     * {@inheritDoc}
     */
    public function distribute(Distribution $distribution): void
    {
        $commands = $this->commandBuilder->build($distribution->getPurchaseItem());
        $this->dispatcher->dispatch(new DistributeByRcon(
            $distribution,
            $commands,
            $this->extraCommands,
            $this->successResponse
        ));
    }
}
