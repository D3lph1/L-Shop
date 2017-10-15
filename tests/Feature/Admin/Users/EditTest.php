<?php

namespace Tests\Feature\Admin\Users;

use Tests\Feature\Future;

/**
 * Class EditTest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package Tests\Feature\Admin\Users
 */
class EditTest extends Future
{
    public function testVisitAdmin()
    {
        $this->visitAdmin('admin.users.edit', ['server' => 1, 'edit' => 1], 200);
    }

    public function testVisitUser()
    {
        $this->visitUser('admin.users.edit', ['server' => 1, 'edit' => 1], 403);
    }

    public function testVisitGuest()
    {
        $this->visitGuest('admin.users.edit', ['server' => 1, 'edit' => 1], 403);
    }

    public function testNotFound()
    {
        $this->visitAdmin('admin.users.edit', ['server' => 1, 'edit' => 5555555], 404);
    }
}
