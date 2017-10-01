<?php

namespace Tests\Feature;

use App\Models\User\EloquentUser;
use App\Repositories\User\UserRepositoryInterface;
use App\TransactionScripts\Authentication;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Container\Container;
use Tests\TestCase;

/**
 * Class CreateUserTest
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package Tests\Feature
 */
class CreateUserTest extends TestCase
{
    /**
     * Create new user test
     *
     * @return void
     */
    public function testCreate()
    {
        /** @var Authentication $authentication */
        $authentication = $this->make(Authentication::class);

        $username = str_random(16);
        $password = str_random(16);

        $authentication->register($username, $username . '@example.com', $password, 0, true, false);

        $this->assertDatabaseHas('users', ['username' => $username]);
        /** @var Sentinel $sentinel */
        $sentinel = $this->make(Sentinel::class);
        /** @var UserRepositoryInterface $repository */
        $repository = $sentinel->getUserRepository();
        $repository->deleteByUsername($username);
    }
}
