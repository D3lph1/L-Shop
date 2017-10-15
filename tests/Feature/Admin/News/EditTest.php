<?php

namespace Tests\Feature\Admin\News;

use Tests\Feature\Future;

/**
 * Class EditTest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package Tests\Feature\Admin\News
 */
class EditTest extends Future
{
    public function testVisitAdmin()
    {
        $this->visitAdmin('admin.news.edit', ['server' => 1, 'id' => 1], 200);
    }

    public function testVisitUser()
    {
        $this->visitUser('admin.news.edit', ['server' => 1, 'id' => 1], 403);
    }

    public function testVisitGuest()
    {
        $this->visitGuest('admin.news.edit', ['server' => 1, 'id' => 1], 403);
    }

    public function testNotFound()
    {
        $this->visitAdmin('admin.news.edit', ['server' => 1, 'id' => 5555555], 404);
    }
}
