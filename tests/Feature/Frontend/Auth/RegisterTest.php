<?php
declare(strict_types = 1);

namespace Tests\Feature\Frontend\Auth;

use App\Services\Auth\Checkpoint\ActivationCheckpoint;
use App\Services\Auth\Checkpoint\Pool;
use App\Services\Infrastructure\Response\Status;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function testWithShortUsername(): void
    {
        $this->transaction();
        $len = config('auth.validation.username.min');
        $f = false;
        try {
            $this->post(route('frontend.auth.register.handle', [
                'username' => str_random($len - 1),
                'email' => 'd3lh1.contact@gmail.com',
                'password' => '123456',
                'password_confirmation' => '123456'
            ]))->json();
        } catch (ValidationException $e) {
            $f = true;
        }
        self::assertTrue($f);

        $this->rollback();
    }

    public function testWithShortPassword(): void
    {
        $this->transaction();
        $len = config('auth.validation.password.min');
        $password = str_random($len - 1);
        $f = false;
        try {
            $this->post(route('frontend.auth.register.handle', [
                'username' => 'D3lph1',
                'email' => 'd3lh1.contact@gmail.com',
                'password' => $password,
                'password_confirmation' => $password
            ]))->json();
        } catch (ValidationException $e) {
            $f = true;
        }
        self::assertTrue($f);

        $this->rollback();
    }

    public function testWithQuickActivation(): void
    {
        $this->transaction();

        $this->app->singleton(Pool::class, function () {
            return new Pool([]);
        });

        $response = $this->post(route('frontend.auth.register.handle', [
            'username' => 'D3lph1',
            'email' => 'd3lh1.contact@gmail.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ]));

        $response->assertStatus(200);
        $response->assertJson([
            'status' => Status::SUCCESS,
            'redirect' => route('frontend.servers')
        ]);
        $this->rollback();
    }

    public function testWithoutQuickActivation(): void
    {
        $this->transaction();

        $this->app->singleton(Pool::class, function () {
            return new Pool([$this->app->make(ActivationCheckpoint::class)]);
        });

        $response = $this->post(route('frontend.auth.register.handle', [
            'username' => 'D3lph1',
            'email' => 'd3lh1.contact@gmail.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ]));

        $response->assertStatus(200);
        $response->assertJson([
            'status' => Status::SUCCESS,
            'redirect' => route('frontend.auth.activation.sent')
        ]);
        $this->rollback();
    }
}
