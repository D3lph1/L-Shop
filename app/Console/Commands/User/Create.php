<?php

namespace App\Console\Commands\User;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class CreateUser
 * Creates a new user with the specified credentials
 *
 * @package App\Console\Commands
 */
class Create extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {username} {email} {password} {--balance=0} {--activate} {--admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new user';

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
        $credentials = [
            'username' => $this->argument('username'),
            'email' => $this->argument('email'),
            'password' => $this->argument('password'),
            'balance' => $this->hasOption('balance') ? $this->option('balance') : 0
        ];

        if (!\Sentinel::validForCreation($credentials)) {
            $this->error('Invalid credentials');

            return 1;
        }

        if (\Sentinel::findByCredentials(['username' => $credentials['username']])) {
            $this->error('User with this username already exists');

            return 2;
        }

        if (\Sentinel::findByCredentials(['email' => $credentials['email']])) {
            $this->error('User with this email already exists');

            return 3;
        }

        $user = null;
        $activate = $this->option('activate');

        try {
            $user = \Sentinel::register($credentials, $activate);
        } catch (\Exception $e) {
            $this->error('User has not been created. Error details: ' . $e->getMessage());

            return 4;
        }

        if (!$user) {
            $this->error('User has not been created.');

            return 5;
        }

        if ($this->option('admin')) {
            $adminRole = \Sentinel::findRoleBySlug('admin');
            $adminRole->users()->attach($user);
        } else {
            $userRole = \Sentinel::findRoleBySlug('user');
            $userRole->users()->attach($user);
        }

        if ($activate) {
            $this->info("User successfully created and activated!");

            return 6;
        }

        $this->info("User successfully created!");

        return 0;
    }

    /**
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['username', InputArgument::REQUIRED, 'Username'],
            ['email', InputArgument::REQUIRED, 'Email address'],
            ['password', InputArgument::REQUIRED, 'User password'],
        ];
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['balance', InputOption::VALUE_OPTIONAL, 'User balance', 0],
            ['activate', InputOption::VALUE_NONE, 'The user will be activated instantly', false],
            ['admin', InputOption::VALUE_NONE, 'Allows the user administrative rights', false]
        ];
    }
}
