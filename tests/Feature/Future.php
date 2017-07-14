<?php

namespace Tests\Feature;

use Tests\TestCase as BaseTestCase;

class Future extends BaseTestCase
{
    public function visitAdmin($route, array $params, $status, $method = 'get')
    {
        $this->authenticateAdmin();
        $this->$method(route($route, $params))->assertStatus($status);
    }

    public function visitUser($route, array $params, $status, $method = 'get')
    {
        $this->authenticateUser();
        $this->$method(route($route, $params))->assertStatus($status);
    }

    public function visitGuest($route, array $params, $status, $method = 'get')
    {
        $this->$method(route($route, $params))->assertStatus($status);
    }
}
