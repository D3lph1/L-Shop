<?php
declare(strict_types = 1);

namespace App\Console\Commands\DB;

use App\Handlers\Console\DB\SetupHandler;
use Illuminate\Console\Command;

class Setup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:setup {--d|diff}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrates and seeds database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param SetupHandler $handler
     *
     * @return int
     */
    public function handle(SetupHandler $handler): int
    {
        $handler->handle((bool)$this->option('diff'));

        return 0;
    }
}
