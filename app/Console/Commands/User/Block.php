<?php

namespace App\Console\Commands\User;

use App\Services\Ban;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class Block extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:block
                            {username}
                            {duration? : The user block duration in days. 0 or keep value for permanent block}
                            {--reason= : The user block reason}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Block given user';

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
        $duration = $this->argument('duration') ?: null;
        $reason = $this->option('reason');

        $user = \Sentinel::getUserRepository()->findByCredentials(['username' => $username]);

        if (is_null($user)) {
            $this->error('User not found!');

            return 1;
        }

        /** @var Ban $ban */
        $ban = app(Ban::class, ['user' => $user]);
        $result = $ban->banForDays($duration, $reason);

        if ($result) {

            if (empty($duration)) {
                $duration = 'permanently';
            } else {
                $duration = "on $duration day(s)";
            }

            $this->info("User $username has been banned $duration.");

            return 0;
        }
        $this->error('User has not been banned.');

        return 2;
    }
}
