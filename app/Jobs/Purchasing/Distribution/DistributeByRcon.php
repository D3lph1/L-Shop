<?php
declare(strict_types = 1);

namespace App\Jobs\Purchasing\Distribution;

use App\Entity\Distribution;
use App\Exceptions\Distributor\DistributionException;
use App\Repository\Distribution\DistributionRepository;
use App\Services\Purchasing\Distributors\RconDistribution\Connections;
use App\Services\Purchasing\Distributors\RconDistribution\ExtraCommands;
use D3lph1\MinecraftRconManager\Exceptions\RuntimeException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Psr\Log\LoggerInterface;

class DistributeByRcon implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    /**
     * The distribution ID that will be processed in this work.
     *
     * @var int
     */
    private $distributionId;

    /**
     * Commands waiting to be executed.
     *
     * @var string[]
     */
    private $commands;

    /**
     * @var ExtraCommands
     */
    private $extraCommands;

    /**
     * The regular expression (pattern) of a successful answer.
     *
     * @var string
     */
    private $successResponse;

    /**
     * Create a new job instance.
     *
     * @param Distribution  $distribution
     * @param string[]      $commands
     * @param ExtraCommands $extraCommands
     * @param string        $successResponse
     */
    public function __construct(
        Distribution $distribution,
        array $commands,
        ExtraCommands $extraCommands,
        string $successResponse)
    {
        // Only the distribution identifier is saved, so that you do not have problems with the
        // serialization of the entity.
        $this->distributionId = $distribution->getId();
        $this->commands = $commands;
        $this->extraCommands = $extraCommands;
        $this->successResponse = $successResponse;
    }

    /**
     * Execute the job.
     *
     * @param Connections            $connections
     * @param DistributionRepository $repository
     * @param LoggerInterface        $logger
     */
    public function handle(Connections $connections, DistributionRepository $repository, LoggerInterface $logger): void
    {
        $distribution = $repository->find($this->distributionId);
        if ($distribution === null) {
            return;
        }

        $connection = null;
        try {
            $connection = $connections->connect(
                $distribution->getPurchaseItem()->getProduct()->getCategory()->getServer()
            );
        } catch (RuntimeException $e) {
            $logger->error("Connection failed: {$e->getMessage()}", $this->context());

            throw new DistributionException('', 0, $e);
        }

        try {
            // Execute extra commands one by one.
            foreach ($this->extraCommands->getExtraBeforeCommands() as $command) {
                $connection->send($command);
            }
        } catch (\Exception $e) {
            $logger->error("Error sending request: {$e->getMessage()}", $this->context());

            throw new DistributionException('', 0, $e);
        }

        $step = 1;
        $total = count($this->commands);
        // Execute main commands one by one.
        foreach ($this->commands as $command) {
            $logger->debug("Attempting to execute command: ({$step}/{$total})\"{$command}\"", $this->context());

            try {
                // Send request...
                $response = $connection->send($command);

                $logger->debug("Received response: \"{$response}\"");
            } catch (RuntimeException $e) {
                $logger->error("Error sending request: {$e->getMessage()}", $this->context());

                throw new DistributionException('', 0, $e);
            }

            // Check if the response matches a successful response pattern.
            if (!preg_match($this->successResponse, $response)) {
                throw new DistributionException(
                    "The response {$response} received from the server does not correspond to pattern {$this->successResponse}"
                );
            }
            $logger->debug("The response received from the server has been successfully mapped to a "
                . "successful response pattern.", $this->context());
        }

        // The products were successfully delivered, the distribution was deleted.
        $repository->remove($distribution);

        try {
            // Execute extra commands one by one.
            foreach ($this->extraCommands->getExtraAfterCommands() as $extraAfterCommand) {
                $connection->send($extraAfterCommand);
            }
        } catch (\Exception $e) {
            $logger->error("Error sending request: {$e->getMessage()}", $this->context());

            throw new DistributionException('', 0, $e);
        }
    }

    /**
     * Returns context for logger.
     *
     * @return array
     */
    private function context(): array
    {
        return [
            'distribution',
            ['distribution_id' => $this->distributionId],
            self::class,
            'in queue'
        ];
    }
}
