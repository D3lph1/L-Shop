<?php

namespace Tests\Feature\Admin\Users;

use Tests\Feature\Future;

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
