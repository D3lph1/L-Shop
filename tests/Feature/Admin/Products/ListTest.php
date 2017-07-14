<?php

namespace Tests\Feature\Admin\Products;

use Tests\Feature\Future;

class ListTest extends Future
{
    public function testVisitAdmin()
    {
        $this->visitAdmin('admin.products.list', ['server' => 1], 200);
    }

    public function testVisitUser()
    {
        $this->visitUser('admin.products.list', ['server' => 1], 403);
    }

    public function testVisitGuest()
    {
        $this->visitGuest('admin.products.list', ['server' => 1], 403);
    }
}
