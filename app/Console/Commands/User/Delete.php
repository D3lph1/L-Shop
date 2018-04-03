<?php
declare(strict_types = 1);

namespace App\Console\Commands\User;

use App\Console\Command;
use App\Handlers\Consoe\User\DeleteHandler;
use App\Exceptions\User\DoesNotExistException;

class Delete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:delete {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete given user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param DeleteHandler $handler
     *
     * @return int
     */
    public function handle(DeleteHandler $handler): int
    {
        $this->alert(__('commands.user.delete.title'));
        $this->warn(__('commands.user.delete.description'));

        // Confirm user deletion.
        $confirmation = $this->choice(
            __('commands.user.delete.confirm'),
            [__('common.no'), __('common.yes')],
            0
        );
        if ($confirmation === __('common.no')) {
            // Deleting canceled.
            $this->comment(__('commands.user.delete.canceled'));

            return 3;
        }

        try {
            $handler->handle($this->argument('user'));
            $this->info(__('commands.user.delete.success'));

            return 0;
        } catch (DoesNotExistException $e) {
            $this->error(__('commands.user.roles.attach.user_not_found', ['username' => $e->getCriteria()]));

            return 1;
        }
    }
}
