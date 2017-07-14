<?php

namespace Tests\Feature\Admin\Items;

use Tests\Feature\Future;

class EditTest extends Future
{
    public function testVisitAdmin()
    {
        $this->visitAdmin('admin.items.edit', ['server' => 1, 'item' => 5], 200);
    }

    public function testVisitUser()
    {
        $this->visitUser('admin.items.edit', ['server' => 1, 'item' => 5], 403);
    }

    public function testVisitGuest()
    {
        $this->visitGuest('admin.items.edit', ['server' => 1, 'item' => 5], 403);
    }

    public function testNotFound()
    {
        $this->visitAdmin('admin.items.edit', ['server' => 1, 'item' => 5555555], 404);
    }
}
