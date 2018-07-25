<?php
declare(strict_types = 1);

namespace App\Jobs\Purchasing\Distribution;

use App\Entity\Distribution;
use App\Exceptions\Distributor\DistributionException;
use App\Repository\Distribution\DistributionRepository;
use App\Services\Purchasing\Distributors\RconDistribution\Connections;
use App\Services\Purchasing\Distributors\RconDistribution\ExecutableCommands;
use D3lph1\MinecraftRconManager\Connection;
use D3lph1\MinecraftRconManager\Exceptions\RuntimeException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Psr\Log\LoggerInterface;

/**
 * Class DistributeByRcon
 * Performs execution of Rcon commands in the queue for the distributing of products to the player.
 */
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
     * @var ExecutableCommands
     */
    private $commands;

    /**
     * Create a new job instance.
     *
     * @param Distribution       $distribution
     * @param ExecutableCommands $commands
     */
    public function __construct(
        Distribution $distribution,
        ExecutableCommands $commands)
    {
        // Only the distribution identifier is saved, so that you do not have problems with the
        // serialization of the entity.
        $this->distributionId = $distribution->getId();
        $this->commands = $commands;
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

        $connection = $this->retrieveConnection($connections, $distribution, $logger);
        $this->sendExtraCommands($this->commands->getExtraBeforeCommands(), $connection, $logger);
        $this->sendCommands($connection, $logger);

        // The products were successfully delivered, the distribution was deleted.
        $repository->remove($distribution);

        $this->sendExtraCommands($this->commands->getExtraAfterCommands(), $connection, $logger);
    }

    private function retrieveConnection(Connections $connections, Distribution $distribution, LoggerInterface $logger): Connection
    {
        try {
            return $connections->connect(
                $distribution->getPurchaseItem()->getProduct()->getCategory()->getServer()
            );
        } catch (RuntimeException $e) {
            $logger->error("Connection failed: {$e->getMessage()}", $this->context());

            throw new DistributionException('', 0, $e);
        }
    }

    private function sendCommands(Connection $connection, LoggerInterface $logger)
    {
        $step = 1;
        $total = count($this->commands->getMainCommands());
        // Execute main commands one by one.
        foreach ($this->commands->getMainCommands() as $command) {
            $logger->debug("Attempting to execute command ({$step}/{$total}): \"{$command->getCommand()}\"", $this->context());

            try {
                // Send request...
                $response = $connection->send($command->getCommand());

                $logger->debug("Received response: \"{$response}\"");
            } catch (RuntimeException $e) {
                $logger->error("Error sending request: {$e->getMessage()}", $this->context());

                throw new DistributionException('', 0, $e);
            }

            if ($command->getResponsePattern() !== null) {
                // Check if the response matches a successful response pattern.
                if (!preg_match($command->getResponsePattern(), $response)) {
                    $msg = "The response \"{$response}\" received from the server does not correspond to pattern \"{$command->getResponsePattern()}\"";
                    $logger->warning($msg, $this->context());
                    throw new DistributionException($msg);
                }
                $logger->debug("The response \"$response\" received from the server has been successfully mapped to a "
                    . "successful response pattern \"{$command->getResponsePattern()}\".", $this->context());
            } else {
                $logger->debug("A response mapping is not used for this query", $this->context());
            }
        }
    }

    private function sendExtraCommands(array $commands, Connection $connection, LoggerInterface $logger)
    {
        try {
            // Execute extra commands one by one.
            foreach ($commands as $command) {
                $connection->send($command);
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
            self::class,
            ['distribution_id' => $this->distributionId],
            'in queue'
        ];
    }
}
