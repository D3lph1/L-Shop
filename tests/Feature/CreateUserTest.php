<?php

namespace Tests\Feature;

use App\Models\User\EloquentUser;
use Illuminate\Container\Container;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    /**
     * Create new user test
     *
     * @return void
     */
    public function testCreate()
    {
        $registrar = Container::getInstance()->make('registrar');

        $username = str_random(16);
        $password = str_random(16);

        $registrar->register($username, $username . '@example.com', $password, 0, true, false);

        $this->assertDatabaseHas('users', ['username' => $username]);
        EloquentUser::where('username', $username)->delete();
    }
}
