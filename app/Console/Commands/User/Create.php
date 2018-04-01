<?php
declare(strict_types = 1);

namespace App\Console\Commands\User;

use App\Console\Command;
use App\Services\Auth\Auth;
use App\Services\Validation\Rule;
use App\Services\Validation\RulesBuilder;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Factory;

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
     * @param Auth    $auth
     *
     * @return mixed
     */
    public function handle(Auth $auth)
    {
        $this->alert(__('commands.user.create.greeting'));
        $username = $this->ask(__('commands.user.create.username'));
        $validator = $this->usernameValidator($username);

        //
    }

    private function usernameValidator($username): Validator
    {
        /** @var Repository $config */
        $config = app(Repository::class);

        return app(Factory::class)->make(compact('username'), [
            'username' => (new RulesBuilder())
                ->addRule(new Rule('required'))
                ->addRule(new Rule('string'))
                ->addRule(new Rule('min', $config->get('auth.validation.username.min')))
                ->addRule(new Rule('max', $config->get('auth.validation.username.max')))
                ->addRule(new Rule($config->get('auth.validation.username.rule')))
                ->build()
        ]);
    }
}
