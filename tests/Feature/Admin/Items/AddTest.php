<?php

namespace Tests\Feature\Admin\Items;

use Tests\Feature\Future;

/**
 * Class AddTest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package Tests\Feature\Admin\Items
 */
class AddTest extends Future
{
    public function testVisitAdmin()
    {
        $this->visitAdmin('admin.items.add', ['server' => 1], 200);
    }

    public function testVisitUser()
    {
        $this->visitUser('admin.items.add', ['server' => 1], 403);
    }

    public function testVisitGuest()
    {
        $this->visitGuest('admin.items.add', ['server' => 1], 403);
    }
}
