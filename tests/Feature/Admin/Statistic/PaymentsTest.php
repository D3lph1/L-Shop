<?php

namespace Tests\Feature\Admin\Statistic;

use Tests\Feature\Future;

/**
 * Class PaymentsTest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package Tests\Feature\Admin\Statistic
 */
class PaymentsTest extends Future
{
    public function testVisitAdmin()
    {
        $this->visitAdmin('admin.statistic.payments', ['server' => 1], 200);
    }

    public function testVisitUser()
    {
        $this->visitUser('admin.statistic.payments', ['server' => 1], 403);
    }

    public function testVisitGuest()
    {
        $this->visitGuest('admin.statistic.payments', ['server' => 1], 403);
    }
}
