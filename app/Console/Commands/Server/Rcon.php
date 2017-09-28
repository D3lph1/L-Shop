<?php
declare(strict_types = 1);

namespace App\Console\Commands\Server;

use App\Repositories\Server\ServerRepositoryInterface;
use Cartalyst\Support\Collection;
use D3lph1\MinecraftRconManager\Connector;
use D3lph1\MinecraftRconManager\Exceptions\ConnectSocketException;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

/**
 * Class Rcon
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Console\Commands\Server
 */
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
    protected $description = 'Send command to server using RCON.';

    /**
     * @var ServerRepositoryInterface
     */
    private $serverRepository;
    /**
     * @var Connector
     */
    private $rconConnector;

    /**
     * Create a new command instance.
     */
    public function __construct(ServerRepositoryInterface $serverRepository, Connector $rconConnector)
    {
        parent::__construct();

        $this->serverRepository = $serverRepository;
        $this->rconConnector = $rconConnector;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Request $request)
    {
        $this->info($request->method());

        $servers = $this->serverRepository->all();
        $names = $servers->map(function ($item) {
            return $item->name;
        });

        $selected = $this->choice('Select server', $names->toArray());

        /** @var Collection $filtered */
        $filtered = $servers->filter(function ($item) use ($selected) {
            return $selected === $item->name;
        });

        if (!$filtered) {
            $this->error('Server not found!');

            return 1;
        }
        /** @var Server $filtered */
        $filtered = $filtered->first();
        $this->info("The {$filtered->name} server is selected. Start typing commands. To stop typing, \"exit\".");

        while (true) {
            $cmd = $this->ask('Command');
            if (mb_strtolower($cmd) === 'exit') {
                return 0;
            }

            try {
                $rcon = $this->rconConnector->get($filtered->id);
            } catch (ConnectSocketException $e) {
                $this->error('Connection failed!');

                continue;
            }

            $result = $rcon->send($cmd);
            $this->line($result);
        }
    }
}
