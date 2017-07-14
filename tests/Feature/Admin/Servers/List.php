<?php

namespace Tests\Feature\Admin\Servers;

use Tests\Feature\Future;

class ListTest extends Future
{
    public function testVisitAdmin()
    {
        $this->visitAdmin('admin.servers.list', ['server' => 1], 200);
    }

    public function testVisitUser()
    {
        $this->visitUser('admin.servers.list', ['server' => 1], 403);
    }

    public function testVisitGuest()
    {
        $this->visitGuest('admin.servers.list', ['server' => 1], 403);
    }

    public function testEnable()
    {
        $this->visitAdmin('admin.servers.enable', ['server' => 1, 'enable' => 1], 302, 'post');
    }

    public function testDisable()
    {
        $this->visitAdmin('admin.servers.disable', ['server' => 1, 'disable' => 1], 302, 'post');
    }
}
