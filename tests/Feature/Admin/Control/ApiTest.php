<?php

namespace Tests\Feature\Admin\Control;

use Tests\Feature\Future;

class ApiTest extends Future
{
    public function testVisitAdmin()
    {
        $this->visitAdmin('admin.control.api', ['server' => 1], 200);
    }

    public function testVisitUser()
    {
        $this->visitUser('admin.control.api', ['server' => 1], 403);
    }

    public function testVisitGuest()
    {
        $this->visitGuest('admin.control.api', ['server' => 1], 403);
    }
}
