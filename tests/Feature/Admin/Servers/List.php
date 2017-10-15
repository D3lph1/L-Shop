<?php

namespace Tests\Feature\Admin\Servers;

use Tests\Feature\Future;

/**
 * Class ListTest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package Tests\Feature\Admin\Servers
 */
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
