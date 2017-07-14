<?php

namespace Tests\Feature\Admin\Servers;

use Tests\Feature\Future;

class AddTest extends Future
{
    public function testVisitAdmin()
    {
        $this->visitAdmin('admin.servers.add', ['server' => 1], 200);
    }

    public function testVisitUser()
    {
        $this->visitUser('admin.servers.add', ['server' => 1], 403);
    }

    public function testVisitGuest()
    {
        $this->visitGuest('admin.servers.add', ['server' => 1], 403);
    }
}
