<?php

namespace Tests\Unit\Users;

use App\Models\User\UserInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\User\Permissions;
use Tests\TestCase;

/**
 * Class PermissionsTest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package Tests\Unit\Users
 */
class PermissionsTest extends TestCase
{
    public function testHasAccess()
    {
        /** @var UserRepositoryInterface $repository */
        $repository = $this->make(UserRepositoryInterface::class);
        /** @var UserInterface $user */
        $user = $repository->findByCredentials(['username' => 'admin']);
        $permissions = new Permissions($user);
        $this->assertTrue($permissions->hasAccess(['user.admin']));

        /** @var UserInterface $user */
        $user = $repository->findByCredentials(['username' => 'user']);
        $permissions = new Permissions($user);
        $this->assertFalse($permissions->hasAccess(['user.admin']));
    }
}
