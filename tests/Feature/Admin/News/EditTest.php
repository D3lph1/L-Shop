<?php

namespace Tests\Feature\Admin\News;

use Tests\Feature\Future;

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
