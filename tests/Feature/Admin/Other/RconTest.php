<?php

namespace Tests\Feature\Admin\Other;

use Tests\Feature\Future;

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
