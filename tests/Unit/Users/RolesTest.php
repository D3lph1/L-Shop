<?php

namespace Tests\Unit\Users;

use App\Models\User\UserInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\User\Roles;
use Tests\TestCase;

/**
 * Class RolesTest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package Tests\Unit\Users
 */
class RolesTest extends TestCase
{
    public function testInRole()
    {
        /** @var UserRepositoryInterface $repository */
        $repository = $this->make(UserRepositoryInterface::class);
        /** @var UserInterface $user */
        $user = $repository->findByCredentials(['username' => 'admin']);
        $roles = new Roles($user);
        $this->assertTrue($roles->inRole('admin'));
        $this->assertFalse($roles->inRole('user'));

        /** @var UserInterface $user */
        $user = $repository->findByCredentials(['username' => 'user']);
        $roles = new Roles($user);
        $this->assertTrue($roles->inRole('user'));
        $this->assertFalse($roles->inRole('admin'));
    }
}
