<?php

namespace Tests\Feature\Admin\Pages;

use Tests\Feature\Future;

/**
 * Class EditTest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package Tests\Feature\Admin\Pages
 */
class EditTest extends Future
{
    public function testVisitAdmin()
    {
        $this->visitAdmin('admin.pages.edit', ['server' => 1, 'id' => 1], 200);
    }

    public function testVisitUser()
    {
        $this->visitUser('admin.pages.edit', ['server' => 1, 'id' => 1], 403);
    }

    public function testVisitGuest()
    {
        $this->visitGuest('admin.pages.edit', ['server' => 1, 'id' => 1], 403);
    }

    public function testNotFound()
    {
        $this->visitAdmin('admin.pages.edit', ['server' => 1, 'id' => 5555555], 404);
    }
}
