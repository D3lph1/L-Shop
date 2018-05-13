<?php
declare(strict_types = 1);

namespace Tests\Feature\Frontend\Auth;

use App\Services\Auth\Checkpoint\ActivationCheckpoint;
use App\Services\Auth\Checkpoint\Pool;
use App\Services\Response\Status;
use Tests\TestCase;

class LoginTest extends TestCase
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
        $this->app->singleton(Pool::class, function () {
            return new Pool([]);
        });
        $this->register();
        $response = $this->post(route('frontend.auth.login.handle'), [
            'username' => 'D3lph1',
            'password' => '123456'
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => Status::SUCCESS
        ]);
        $this->rollback();
    }

    public function testUserNotActivated(): void
    {
        $this->transaction();
        $this->app->singleton(Pool::class, function () {
            return new Pool([$this->app->make(ActivationCheckpoint::class)]);
        });
        $this->register();
        $response = $this->post(route('frontend.auth.login.handle'), [
            'username' => 'D3lph1',
            'password' => '123456'
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'not_activated'
        ]);
        $this->rollback();
    }

    public function testBadCredentials(): void
    {
        $this->transaction();
        $this->app->singleton(Pool::class, function () {
            return new Pool([]);
        });
        $this->register();
        $response = $this->post(route('frontend.auth.login.handle'), [
            'username' => 'admin',
            'password' => 'qwerty'
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => Status::FAILURE
        ]);
        $this->rollback();
    }
}
