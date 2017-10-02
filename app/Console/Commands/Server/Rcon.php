<?php
declare(strict_types = 1);

namespace App\Console\Commands\Server;

use App\Models\Server\ServerInterface;
use App\Repositories\Server\ServerRepositoryInterface;
use App\Services\Rcon\Colorizers\ConsoleColorizer;
use App\Traits\ContainerTrait;
use Cartalyst\Support\Collection;
use D3lph1\MinecraftRconManager\Connector;
use D3lph1\MinecraftRconManager\Exceptions\ConnectSocketException;
use Illuminate\Console\Command;

/**
 * Class Rcon
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Console\Commands\Server
 */
class Rcon extends Command
{
    use ContainerTrait;

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
     */
    public function handle(): int
    {
        /** @var ConsoleColorizer $colorizer */
        $colorizer = $this->make(ConsoleColorizer::class);

        $servers = collect($this->serverRepository->all(['id', 'name']));
        $names = $servers->map(function ($item) {
            /** @var ServerInterface $item */
            return $item->getName();
        });

        $selected = $this->choice('Select server', $names->toArray());

        /** @var Collection $filtered */
        $filtered = $servers->filter(function ($item) use ($selected) {
            /** @var ServerInterface $item */
            return $selected === $item->getName();
        });

        if (!$filtered) {
            $this->error('Server not found!');

            return 1;
        }

        $filtered = $filtered->first();
        /** @var ServerInterface $filtered */
        $this->info("The {$filtered->getName()} server is selected. Start typing commands. To stop typing, \"exit\".");
        /** @var ConsoleColorizer $colorizer */
        $colorizer = $this->make(ConsoleColorizer::class);

        while (true) {
            $cmd = $this->ask('Command');
            if (mb_strtolower($cmd) === 'exit') {
                return 0;
            }

            try {
                $rcon = $this->rconConnector->get($filtered->getId());
            } catch (ConnectSocketException $e) {
                $this->error('Connection failed!');

                continue;
            }

            /** @var string $result */
            $result = $rcon->send($cmd);
            $this->line($colorizer->colorize($result));
        }

        return 0;
    }
}
