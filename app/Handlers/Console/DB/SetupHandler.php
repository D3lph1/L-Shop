<?php
declare(strict_types = 1);

namespace App\Handlers\Console\DB;

use Illuminate\Contracts\Console\Kernel;

class SetupHandler
{
    /**
     * @var Kernel
     */
    private $console;

    public function __construct(Kernel $console)
    {
        $this->console = $console;
    }

    public function handle(bool $diff): void
    {
        if ($diff) {
            $this->console->call('doctrine:migrations:diff');
        }

        $this->console->call('doctrine:migrations:refresh');
        $this->console->call('db:seed');
    }
}
