<?php
declare(strict_types = 1);

namespace App\Console\Commands\User;

use Cartalyst\Sentinel\Sentinel;
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
     * @var Sentinel
     */
    private $sentinel;

    /**
     * Create a new command instance.
     */
    public function __construct(Sentinel $sentinel)
    {
        parent::__construct();
        $this->sentinel = $sentinel;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $username = $this->argument('username');
        $user = $this->sentinel->getUserRepository()->findByCredentials(['username' => $username]);

        if (!$user) {
            $this->error("User with username $username not found");

            return 1;
        }

        // TODO: Refactor it!
        $user->delete();
        $this->info('User has been successfully removed!');

        return 0;
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
