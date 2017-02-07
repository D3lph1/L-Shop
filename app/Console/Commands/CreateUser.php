<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Creates a new user with the specified username and password "123456"
 */
class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'new:user {username}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
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
        $credentials = [
            'username' => $this->argument('username'),
            'email' => $this->argument('username') . '@gmail.com',
            'password' => bcrypt(123456)
        ];

        try {
            $user = \Sentinel::registerAndActivate($credentials);
        }catch (\PDOException $e) {
            $this->error('User has not been created. Error text: ' . $e->getMessage());
        }

        $this->info('User has been created successfully!');
    }
}
