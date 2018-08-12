<?php
declare(strict_types = 1);

namespace Tests\Integrated\Services\Auth;

use App\Services\Auth\Checkpoint\Pool;

trait AuthTrait
{
    private function registerPool(array $pool)
    {
        $this->app->singleton(Pool::class, function () use ($pool) {
            return new Pool($pool);
        });
    }
}
