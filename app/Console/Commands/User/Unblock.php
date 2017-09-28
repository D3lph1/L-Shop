<?php
declare(strict_types = 1);

namespace App\Console\Commands\User;

use App\Services\Ban;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Console\Command;

/**
 * Class Unblock
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Console\Commands\User
 */
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
        $ban = app(Ban::class);
        $result = $ban->pardon($user);

        if ($result) {
            $this->info('User unblocked successfully!');

            return 0;
        }
        $this->error('User has not been unblocked.');

        return 1;
    }
}
