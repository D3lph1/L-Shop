<?php

namespace Tests\Feature\Admin\Pages;

use Tests\Feature\Future;

/**
 * Class AddTest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package Tests\Feature\Admin\Pages
 */
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
