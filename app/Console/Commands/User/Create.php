<?php
declare(strict_types=1);

namespace App\Console\Commands\User;

use App\Console\Command;
use App\Exceptions\InvalidArgumentException;
use App\Handlers\Consoe\User\CreateHandler;
use App\Services\Auth\Exceptions\EmailAlreadyExistsException;
use App\Services\Auth\Exceptions\UsernameAlreadyExistsException;
use Illuminate\Validation\ValidationException;

class Create extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new user';

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
     * @param CreateHandler $handler
     *
     * @return int
     */
    public function handle(CreateHandler $handler): int
    {
        $this->alert(__('commands.user.create.greeting'));

        // Filling username.
        $continue = true;
        do {
            try {
                $handler->setUsername($this->ask(__('commands.user.create.username')));
            } catch (ValidationException $e) {
                $this->displayErrors($e->errors());
                continue;
            } catch (UsernameAlreadyExistsException $e) {
                $this->error(__('msg.admin.users.edit.username_already_exists'));
                continue;
            }
            $continue = false;
        } while ($continue);

        // Filling email.
        $continue = true;
        do {
            try {
                $handler->setEmail($this->ask(__('commands.user.create.email')));
            } catch (ValidationException $e) {
                $this->displayErrors($e->errors());
                continue;
            } catch (EmailAlreadyExistsException $e) {
                $this->error(__('msg.admin.users.edit.email_already_exists'));
                continue;
            }
            $continue = false;
        } while ($continue);

        // Filling password.
        $continue = true;
        do {
            try {
                $handler->setPassword($this->secret(__('commands.user.create.password')));
            } catch (ValidationException $e) {
                $this->displayErrors($e->errors());
                continue;
            }
            $continue = false;
        } while ($continue);

        // Password confirmation.
        $continue = true;
        do {
            try {
                $handler->setPasswordConfirmation($this->secret(__('commands.user.create.password_confirmation')));
            } catch (InvalidArgumentException $e) {
                $this->displayErrors(__('commands.user.create.password_confirmation_error'));
                continue;
            }
            $continue = false;
        } while ($continue);

        $activate = $this->choice(
            __('commands.user.create.activate'),
            [__('common.no'), __('common.yes')],
            1
        );
        $handler->setActivate($activate === __('common.yes'));
        // Create user.
        $handler->handle();
        $this->info(__('commands.user.create.success'));

        return 0;
    }
}
