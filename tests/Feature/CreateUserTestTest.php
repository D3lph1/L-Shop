<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Container\Container;
use App\Models\User;
use Tests\TestCase;


class CreateUserTestTest extends TestCase
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
