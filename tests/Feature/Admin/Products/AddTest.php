<?php

namespace Tests\Feature\Admin\Products;

use Tests\Feature\Future;

/**
 * Class AddTest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package Tests\Feature\Admin\Products
 */
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
