<?php

namespace Tests\Feature\Admin\Servers;

use Tests\Feature\Future;

/**
 * Class AddTest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package Tests\Feature\Admin\Servers
 */
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
