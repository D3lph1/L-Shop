<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;

/**
 * Class SashokTest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package Tests\Feature\Api
 */
class SashokTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        s_set('api.enabled', true);
        s_set('api.launcher.sashok.auth.enabled', true);
    }

    public function testSuccess()
    {
        $result = $this->request('admin', 'admin');
        $result->assertSeeText(str_replace('{username}', 'admin', s_get('api.launcher.sashok.auth.format')));
    }

    public function testInvalidPassword()
    {
        $result = $this->request('admin', '123456');
        $result->assertSeeText(s_get('api.launcher.sashok.auth.error_message'));
    }

    public function testInvalidUsername()
    {
        $result = $this->request('fake_user', '123456');
        $result->assertSeeText(s_get('api.launcher.sashok.auth.error_message'));
    }

    private function request(string $username, string $password): TestResponse
    {
        return $this->get(route('api.launcher.sashok.auth', ['username' => $username, 'password' => $password]));
    }
}
