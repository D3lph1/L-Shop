<?php

namespace Tests\Feature\Admin\Users;

use Tests\Feature\Future;

class ListTest extends Future
{
    public function testVisitAdmin()
    {
        $this->visitAdmin('admin.users.list', ['server' => 1], 200);
    }

    public function testVisitUser()
    {
        $this->visitUser('admin.users.list', ['server' => 1], 403);
    }

    public function testVisitGuest()
    {
        $this->visitGuest('admin.users.list', ['server' => 1], 403);
    }
}
