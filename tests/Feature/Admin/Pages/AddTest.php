<?php

namespace Tests\Feature\Admin\Pages;

use Tests\Feature\Future;

class AddTest extends Future
{
    public function testVisitAdmin()
    {
        $this->visitAdmin('admin.pages.add', ['server' => 1], 200);
    }

    public function testVisitUser()
    {
        $this->visitUser('admin.pages.add', ['server' => 1], 403);
    }

    public function testVisitGuest()
    {
        $this->visitGuest('admin.pages.add', ['server' => 1], 403);
    }
}
