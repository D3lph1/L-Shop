<?php
declare(strict_types = 1);

namespace App\Console\Commands\User;

use App\Exceptions\User\EmailAlreadyExistsException;
use App\Exceptions\User\UnableToCreateUser;
use App\Exceptions\User\UsernameAlreadyExistsException;
use App\Traits\Validator;
use App\TransactionScripts\Authentication;
use Illuminate\Console\Command;
use Illuminate\Container\Container;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class CreateUser
 * Creates a new user with the specified credentials
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Console\Commands
 */
class Create extends Command
{
    use Validator;

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
     * @var Authentication
     */
    private $authentication;

    /**
     * Create a new command instance.
     */
    public function __construct(Authentication $authentication)
    {
        parent::__construct();
        $this->authentication = $authentication;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $username = $username = $this->argument('username');
        if (!$this->validateUsername($username)) {
            $this->error('Invalid username.');

            return 1;
        }

        $email = $this->argument('email');

        if (\Illuminate\Support\Facades\Validator::make(['email' => $email], ['email' => 'email'])->fails()) {
            $this->error('Invalid email.');

            return 2;
        }

        $password = $this->argument('password');
        $balance = (float)($this->hasOption('balance') ? $this->option('balance') : 0);
        $forceActivate = (bool)$this->option('activate');
        $admin = (bool)$this->option('admin');

        try {
            $this->authentication->register($username, $email, $password, $balance, $forceActivate, $admin);
        } catch (UsernameAlreadyExistsException $e) {
            $this->error('User with this username already exists');

            return 3;
        } catch (EmailAlreadyExistsException $e) {
            $this->error('User with this email already exists');

            return 4;
        } catch (UnableToCreateUser $e) {
            $this->error('User has not been created. Error details: ' . $e->getMessage());

            return 5;
        }

        if ($forceActivate) {
            $this->info("User successfully created and activated!");

            return 0;
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
