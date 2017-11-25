<?php

namespace Tests;

use App\Traits\ContainerTrait;
use Cartalyst\Sentinel\Throttling\ThrottleRepositoryInterface;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * Class TestCase
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package Tests
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    use ContainerTrait;

    public function setUp()
    {
        parent::setUp();
    }

    protected function authenticateUser()
    {
        if (!\Sentinel::authenticate(['username' => 'user', 'password' => 'user'])) {
            throw new \RuntimeException('Can not authorize user');
        }
    }

    protected function authenticateAdmin()
    {
        if (!\Sentinel::authenticate(['username' => 'admin', 'password' => 'admin'])) {
            throw new \RuntimeException('Can not authorize admin');
        }
    }
}
