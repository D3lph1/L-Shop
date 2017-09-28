<?php
declare(strict_types = 1);

namespace App\Console\Commands\User;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class RemoveUser
 * Remove user by username
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Console\Commands
 */
class Remove extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:remove {username}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove given user';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $username = $this->argument('username');
        $user = \Sentinel::findByCredentials(['username' => $username]);

        if (!$user) {
            $this->error("User with username $username not found");

            return;
        }

        $user->delete();
        $this->info('User has been successfully removed!');
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return [
            ['username', InputArgument::REQUIRED, 'Username']
        ];
    }
}
