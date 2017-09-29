<?php
declare(strict_types = 1);

namespace App\Console\Commands\User;

use App\Exceptions\User\AlreadyActivatedException;
use App\Exceptions\User\NotFoundException;
use App\TransactionScripts\Authentication;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class Activate
 * Activate given user account
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
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

    private $authentication;

    /**
     * Create a new command instance.
     */
    public function __construct(Authentication $script)
    {
        parent::__construct();
        $this->authentication = $script;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $username = $this->argument('username');

        try {
            $result = $this->authentication->activateByUsername($username);
        } catch (NotFoundException $e) {
            $this->error('User with this username not found.');

            return 1;
        } catch (AlreadyActivatedException $e) {
            $this->error('This user already activated.');

            return 2;
        }

        if ($result) {
            $this->info("User $username has been successfully activated.");

            return 0;
        }
        $this->error('Unable to activate user.');

        return 3;
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
