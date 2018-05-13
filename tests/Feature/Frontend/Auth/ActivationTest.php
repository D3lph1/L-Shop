<?php
declare(strict_types = 1);

namespace Tests\Feature\Frontend\Auth;

use App\Services\Auth\Checkpoint\ActivationCheckpoint;
use App\Services\Auth\Checkpoint\Pool;
use App\Services\Response\Status;
use Tests\TestCase;

class ActivationTest extends TestCase
{
    public function test(): void
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
            'redirect' => 'frontend.auth.activation.sent'
        ]);
        $this->rollback();
    }
}
