<?php

namespace Tests\Feature\Admin\Other;

use Tests\Feature\Future;

/**
 * Class RconTest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package Tests\Feature\Admin\Other
 */
class RconTest extends Future
{
    public function testVisitAdmin()
    {
        $this->visitAdmin('admin.other.rcon', ['server' => 1], 200);
    }

    public function testVisitUser()
    {
        $this->visitUser('admin.other.rcon', ['server' => 1], 403);
    }

    public function testVisitGuest()
    {
        $this->visitGuest('admin.other.rcon', ['server' => 1], 403);
    }
}
