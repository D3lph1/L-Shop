<?php

namespace Tests\Feature\Admin\Info;

use Tests\Feature\Future;

/**
 * Class AboutTest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package Tests\Feature\Admin\Info
 */
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
