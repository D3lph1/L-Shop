<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

/**
 * Class SigninTest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package Tests\Feature\Api
 */
class SigninTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        s_set('api.enabled', true);
        s_set('api.signin.enabled', true);
    }

    public function testSuccess()
    {
        $str = sprintf('%s%s%s', s_get('api.key'), s_get('api.separator'), 'admin');
        $hash = hash(s_get('api.algo'), $str);
        $result = $this->get(route('api.signin', ['username' => 'admin', 'hash' => $hash]));
        $result->assertRedirect(route('servers'));
    }

    public function testFail()
    {
        $result = $this->get(route('api.signin', ['username' => 'D3lph1', 'hash' => 'fake hash']));
        $result->assertRedirect(route('signin'));
    }
}
