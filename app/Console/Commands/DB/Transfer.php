<?php
declare(strict_types = 1);

namespace App\Console\Commands\DB;

use App\Console\Command;
use App\Handlers\Console\DB\AttachDefaultRolesToAllUsers;
use App\Services\Database\Transfer\Pool;
use Illuminate\Container\Container;

class Transfer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:transfer {from} {to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adapts the data stored in the database of the old version of L-Shop to the new version.';

    /**
     * @var Pool
     */
    private $pool;

    /**
     * @var AttachDefaultRolesToAllUsers
     */
    private $attachDefaultRolesToAllUsers;

    /**
     * @var Container
     */
    private $container;

    /**
     * Create a new command instance.
     *
     * @param Pool                         $pool
     * @param AttachDefaultRolesToAllUsers $attachDefaultRolesToAllUsers
     * @param Container                    $container
     */
    public function __construct(Pool $pool, AttachDefaultRolesToAllUsers $attachDefaultRolesToAllUsers, Container $container)
    {
        parent::__construct();
        $this->pool = $pool;
        $this->attachDefaultRolesToAllUsers = $attachDefaultRolesToAllUsers;
        $this->container = $container;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->info(__('commands.db.transfer.welcome'));
        $version = $this->choice(__('commands.db.transfer.select_version'), $this->pool->versions());
        $transformer = $this->pool->get($version);
        $this->info(__('commands.db.transfer.wait_transfer'));
        $transformer->transfer($this->argument('from'), $this->argument('to'));
        $this->info(__('commands.db.transfer.success_transfer'));
        $this->info(__('commands.db.transfer.wait_seeding'));
        $this->seed(\SettingsSeeder::class);
        $this->seed(\RolesSeeder::class);
        $this->attachDefaultRolesToAllUsers->handle();
        $this->info(__('commands.db.transfer.success_seeding'));

        return 0;
    }

    private function seed(string $seederClass): void
    {
        $seeder = $this->container->make($seederClass);
        $seeder->setCommand($this);
        $seeder->setContainer($this->container);
        // Run database seeder.
        $seeder();
    }
}
