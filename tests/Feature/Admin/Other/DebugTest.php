<?php

namespace Tests\Feature\Admin\Other;

use Tests\Feature\Future;

class DebugTest extends Future
{
    public function testVisitAdmin()
    {
        $this->visitAdmin('admin.other.debug', ['server' => 1], 200);
    }

    public function testVisitUser()
    {
        $this->visitUser('admin.other.debug', ['server' => 1], 403);
    }

    public function testVisitGuest()
    {
        $this->visitGuest('admin.other.debug', ['server' => 1], 403);
    }
}
