<?php

namespace App\Console\Commands\User;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class Activate
 *
 * Activate given user account
 *
 * @package App\Console\Commands\User
 */
class Activate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:activate {username}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activate given user account';

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
     * @return mixed
     */
    public function handle()
    {
        $username = $this->argument('username');
        $user = \Sentinel::findByCredentials(['username' => $username]);

        if (!$user) {
            $this->error('User with this username not found');

            return 1;
        }

        if (\Activation::completed($user)) {
            $this->error('This user already activated');

            return 2;
        }

        \Sentinel::activate($user);
        $this->info("User $username has been successfully activated");

        return 0;
    }

    /**
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['username', InputArgument::REQUIRED, 'Username']
        ];
    }
}
