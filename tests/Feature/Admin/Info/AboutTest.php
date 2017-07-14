<?php

namespace Tests\Feature\Admin\Info;

use Tests\Feature\Future;

class AboutTest extends Future
{
    public function testVisitAdmin()
    {
        $this->visitAdmin('admin.info.about', ['server' => 1], 200);
    }

    public function testVisitUser()
    {
        $this->visitUser('admin.info.about', ['server' => 1], 403);
    }

    public function testVisitGuest()
    {
        $this->visitGuest('admin.info.about', ['server' => 1], 403);
    }
}
