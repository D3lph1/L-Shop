<?php

namespace App\Console\Commands\User;

use App\Services\Ban;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Console\Command;

class Unblock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:unblock {username}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Unblock given user';

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
     * @param Sentinel $sentinel
     *
     * @return mixed
     */
    public function handle(Sentinel $sentinel)
    {
        $username = $this->argument('username');
        $user = $sentinel->getUserRepository()->findByCredentials(['username' => $username]);

        if (is_null($user)) {
            $this->error('User not found!');

            return 1;
        }

        /** @var Ban $ban */
        $ban = app(Ban::class, ['user' => $user]);
        $result = $ban->unblock();

        if ($result) {
            $this->info('User unbanned successfully!');

            return 0;
        }
        $this->error('User has not been unbanned.');

        return 1;
    }
}
