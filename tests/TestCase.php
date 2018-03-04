<?php
declare(strict_types = 1);

namespace Tests;

use App\Services\Auth\Auth;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function transaction(): void
    {
        $this->app->make(EntityManagerInterface::class)->beginTransaction();
    }

    protected function rollback(): void
    {
        $this->app->make(EntityManagerInterface::class)->rollback();
    }

    protected function authAdmin(): void
    {
        app(Auth::class)->authenticate('admin', 'admin');
    }
}
