<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

/**
 * Class SignupTest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package Tests\Feature\Api
 */
class SignupTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        s_set('api.enabled', true);
        s_set('api.signup.enabled', true);
    }

    public function testSuccess()
    {
        $key = s_get('api.key');
        $separator = s_get('api.separator');
        $str = $key . $separator . 'newbie' . $separator . 'newbie@example.com' . $separator . 'newbie' . $separator . '15' . $separator . '1' . $separator . '0';
        $hash = hash(s_get('api.algo'), $str);

        $result = $this->get(route('api.signup', [
            'username' => 'newbie',
            'email' => 'newbie@example.com',
            'password' => 'newbie',
            'balance' => '15',
            'force_activate' => '1',
            'admin' => '0',
            'hash' => $hash
        ]));

        $result->assertJson(['code' => 0, 'status' => 'success']);
    }
}
