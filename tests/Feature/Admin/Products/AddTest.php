<?php

namespace Tests\Feature\Admin\Products;

use Tests\Feature\Future;

class AddTest extends Future
{
    public function testVisitAdmin()
    {
        $this->visitAdmin('admin.products.add', ['server' => 1], 200);
    }

    public function testVisitUser()
    {
        $this->visitUser('admin.products.add', ['server' => 1], 403);
    }

    public function testVisitGuest()
    {
        $this->visitGuest('admin.products.add', ['server' => 1], 403);
    }
}
