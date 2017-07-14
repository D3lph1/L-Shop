<?php

namespace Tests\Feature\Admin\Statistic;

use Tests\Feature\Future;

class ShowTest extends Future
{
    public function testVisitAdmin()
    {
        $this->visitAdmin('admin.statistic.show', ['server' => 1], 200);
    }

    public function testVisitUser()
    {
        $this->visitUser('admin.statistic.show', ['server' => 1], 403);
    }

    public function testVisitGuest()
    {
        $this->visitGuest('admin.statistic.show', ['server' => 1], 403);
    }
}
