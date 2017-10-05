<?php

namespace Tests\Unit\Users;

use App\Models\User\UserInterface;
use App\Repositories\User\UserRepositoryInterface;
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
        $this->assertTrue($user->getPermissionsManager()->hasAccess(['user.admin']));

        /** @var UserInterface $user */
        $user = $repository->findByCredentials(['username' => 'user']);
        $this->assertFalse($user->getPermissionsManager()->hasAccess(['user.admin']));
    }
}
