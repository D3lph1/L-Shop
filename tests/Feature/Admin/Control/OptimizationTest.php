<?php

namespace Tests\Feature\Admin\Control;

use Tests\Feature\Future;

class OptimizationTest extends Future
{
    public function testVisitAdmin()
    {
        $this->visitAdmin('admin.control.optimization', ['server' => 1], 200);
    }

    public function testVisitUser()
    {
        $this->visitUser('admin.control.optimization', ['server' => 1], 403);
    }

    public function testVisitGuest()
    {
        $this->visitGuest('admin.control.optimization', ['server' => 1], 403);
    }
}
