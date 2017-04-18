<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Container\Container;

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
        User::where('username', $username)->delete();
    }
}
