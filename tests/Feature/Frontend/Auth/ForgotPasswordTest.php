<?php
declare(strict_types = 1);

namespace Tests\Feature\Frontend\Auth;

use App\Services\Response\Status;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    private function register(): void
    {
        $response = $this->post(route('frontend.auth.register.handle', [
            'username' => 'D3lph1',
            'email' => 'd3lph1.contact@gmail.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ]));

        $response->assertJson(['status' => Status::SUCCESS]);
    }

    public function testSuccessfully(): void
    {
        $this->transaction();
        $this->register();
        $response = $this->post(route('frontend.auth.password.forgot.handle'), [
            'email' => 'd3lph1.contact@gmail.com'
        ]);
        $response->assertJson(['status' => Status::SUCCESS]);

        $this->rollback();
    }
}
