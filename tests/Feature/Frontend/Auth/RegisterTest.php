<?php
declare(strict_types = 1);

namespace Tests\Feature\Frontend\Auth;

use App\Services\Response\Status;
use App\Services\Settings\Settings;
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

        $settings = $this->app->make(Settings::class);
        $settings->set('auth.register.send_activation', false);
        $settings->save();

        $response = $this->post(route('frontend.auth.register.handle', [
            'username' => 'D3lph1',
            'email' => 'd3lh1.contact@gmail.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ]));

        $response->assertStatus(200);
        $response->assertJson([
            'status' => Status::SUCCESS,
            'redirect' => 'frontend.auth.servers'
        ]);
        $this->rollback();
    }

    public function testWithoutQuickActivation(): void
    {
        $this->transaction();

        $settings = $this->app->make(Settings::class);
        $settings->set('auth.register.send_activation', true);
        $settings->save();

        $response = $this->post(route('frontend.auth.register.handle', [
            'username' => 'D3lph1',
            'email' => 'd3lh1.contact@gmail.com',
            'password' => '123456',
            'password_confirmation' => '123456'
        ]));

        $response->assertStatus(200);
        $response->assertJson([
            'status' => Status::SUCCESS,
            'redirect' => 'frontend.auth.activation.sent'
        ]);
        $this->rollback();
    }
}
