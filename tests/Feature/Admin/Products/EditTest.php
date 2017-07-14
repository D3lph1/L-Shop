<?php

namespace Tests\Feature\Admin\Products;

use Tests\Feature\Future;

class EditTest extends Future
{
    public function testVisitAdmin()
    {
        $this->visitAdmin('admin.products.edit', ['server' => 1, 'product' => 14], 200);
    }

    public function testVisitUser()
    {
        $this->visitUser('admin.products.edit', ['server' => 1, 'product' => 14], 403);
    }

    public function testVisitGuest()
    {
        $this->visitGuest('admin.products.edit', ['server' => 1, 'product' => 14], 403);
    }

    public function testNotFound()
    {
        $this->visitAdmin('admin.products.edit', ['server' => 1, 'product' => 5555555], 404);
    }
}
