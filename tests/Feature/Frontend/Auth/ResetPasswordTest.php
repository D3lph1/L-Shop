<?php
declare(strict_types = 1);

namespace Tests\Feature\Frontend\Auth;

use App\Repository\User\UserRepository;
use App\Services\Auth\Checkpoint\Pool;
use App\Services\Auth\Reminder;
use App\Services\Infrastructure\Response\Status;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
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

    private function createReminder(): string
    {
        return $this->app->make(Reminder::class)->makeReminder(
            $this->app->make(UserRepository::class)->findByUsername('D3lph1')
        )->getCode();
    }

    public function testSuccessfully(): void
    {
        $this->transaction();
        $this->app->singleton(Pool::class, function () {
            return new Pool([]);
        });
        $this->register();
        $code = $this->createReminder();
        $response = $this->post(route('frontend.auth.password.reset.handle', ['code' => $code]), [
            'password' => 'qwerty',
            'password_confirmation' => 'qwerty'
        ]);
        $response->assertJson(['status' => Status::SUCCESS]);

        $response = $this->post(route('frontend.auth.login.handle'), [
            'username' => 'D3lph1',
            'password' => 'qwerty'
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => Status::SUCCESS
        ]);

        $this->rollback();
    }

    public function testInvalidCode(): void
    {
        $this->transaction();
        $this->app->singleton(Pool::class, function () {
            return new Pool([]);
        });
        $this->register();
        $code = $this->createReminder();
        $invalidCode = $code . 'some_string';
        $response = $this->post(route('frontend.auth.password.reset.handle', ['code' => $invalidCode]), [
            'password' => 'qwerty',
            'password_confirmation' => 'qwerty'
        ]);
        $response->assertJson(['status' => Status::FAILURE]);
        $this->rollback();
    }
}
