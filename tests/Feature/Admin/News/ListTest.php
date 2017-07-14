<?php

namespace Tests\Feature\Admin\News;

use Tests\Feature\Future;

class ListTest extends Future
{
    public function testVisitAdmin()
    {
        $this->visitAdmin('admin.news.list', ['server' => 1], 200);
    }

    public function testVisitUser()
    {
        $this->visitUser('admin.news.list', ['server' => 1], 403);
    }

    public function testVisitGuest()
    {
        $this->visitGuest('admin.news.list', ['server' => 1], 403);
    }
}
