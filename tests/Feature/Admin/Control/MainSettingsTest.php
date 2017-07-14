<?php

namespace Tests\Feature\Admin\Control;

use Tests\Feature\Future;

class MainSettingsTest extends Future
{
    public function testVisitAdmin()
    {
        $this->visitAdmin('admin.control.main_settings', ['server' => 1], 200);
    }

    public function testVisitUser()
    {
        $this->visitUser('admin.control.main_settings', ['server' => 1], 403);
    }

    public function testVisitGuest()
    {
        $this->visitGuest('admin.control.main_settings', ['server' => 1], 403);
    }
}
