<?php

namespace Tests\Feature\Api;

use App\Repositories\User\UserRepositoryInterface;
use Cartalyst\Sentinel\Sentinel;
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
        $username = 'newbie';

        $key = s_get('api.key');
        $separator = s_get('api.separator');
        $str = $key . $separator . $username . $separator . 'newbie@example.com' . $separator . 'newbie' . $separator . '15' . $separator . '1' . $separator . '0';
        $hash = hash(s_get('api.algo'), $str);

        $result = $this->get(route('api.signup', [
            'username' => $username,
            'email' => 'newbie@example.com',
            'password' => 'newbie',
            'balance' => '15',
            'force_activate' => '1',
            'admin' => '0',
            'hash' => $hash
        ]));

        $result->assertJson(['code' => 0, 'status' => 'success']);

        if ($result->json()['code'] === 0) {
            /** @var UserRepositoryInterface $userRepository */
            $userRepository = $this->make(Sentinel::class)->getUserRepository();
            $userRepository->deleteByUsername($username);
        }
    }
}
