<?php
declare(strict_types = 1);

namespace App\Console\Commands;

use App\Console\Command;
use App\Entity\Server;
use App\Repository\Server\ServerRepository;
use D3lph1\MinecraftRconManager\Connector;
use D3lph1\MinecraftRconManager\Exceptions\RuntimeException;

class Rcon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rcon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Launches the interactive Rcon console';

    /**
     * @var ServerRepository
     */
    private $serverRepository;

    /**
     * @var Connector
     */
    private $connector;

    /**
     * Create a new command instance.
     *
     * @param ServerRepository $serverRepository
     * @param Connector        $connector
     */
    public function __construct(ServerRepository $serverRepository, Connector $connector)
    {
        parent::__construct();
        $this->serverRepository = $serverRepository;
        $this->connector = $connector;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info(__('commands.rcon.welcome'));
        $servers = $this->serverRepository->findAll();

        $serversList = array_map(function (Server $server) {
            return $server->getName();
        }, $servers);

        $selectedServerName = $this->choice(__('commands.rcon.select_server'), $serversList);
        $selectedServer = null;
        /** @var Server $server */
        foreach ($servers as $server) {
            if ($server->getName() === $selectedServerName) {
                $selectedServer = $server;
                break;
            }
        }

        $this->info(__('commands.rcon.connecting'));
        try {
            $connection = $this->connector->connect(
                $selectedServer->getIp(),
                $selectedServer->getPort(),
                $selectedServer->getPassword(),
                3
            );
        } catch (RuntimeException $e) {
            $this->error(__('commands.rcon.error'));

            return 1;
        }
        $this->info(__('commands.rcon.connected'));

        while (true) {
            $command = $this->ask(__('commands.rcon.input'));
            if ($command === 'exit') {
                break;
            }

            $response = $connection->send($command);
            $this->info($response);
        }

        return 0;
    }
}
