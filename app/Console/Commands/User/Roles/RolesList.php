<?php
declare(strict_types = 1);

namespace App\Console\Commands\User\Roles;

use App\Console\Command;
use App\Handlers\Consoe\User\Roles\ListHandler;
use App\Exceptions\User\UserNotFoundException;

class RolesList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:roles:list {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display the roles that the user has';

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
     * @param ListHandler $handler
     *
     * @return int
     */
    public function handle(ListHandler $handler): int
    {
        try {
            $dto = $handler->handle($this->argument('user'));

            $rows = [];
            foreach ($dto->getRoles() as $role) {
                $rows[] = [
                    'id' => $role->getId(),
                    'name' => $role->getName()
                ];
            }

            $this->alert(__('commands.user.roles.list.title', ['username' => $dto->getUser()->getUsername()]));
            // Table with roles.
            $this->table(
                [__('commands.user.roles.list.table.id'), __('commands.user.roles.list.table.name')],
                $rows
            );

            return 0;
        } catch (UserNotFoundException $e) {
            $this->error(__('commands.user.roles.attach.user_not_found', ['username' => $e->getCriteria()]));

            return 1;
        }
    }
}
