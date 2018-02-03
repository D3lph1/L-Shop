<?php

namespace Tests;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function transaction()
    {
        $this->app->make(EntityManagerInterface::class)->beginTransaction();
    }

    protected function rollback()
    {
        $this->app->make(EntityManagerInterface::class)->rollback();
    }

    protected function reMigrate()
    {
        $this->app->make(Kernel::class)->call('doctrine:migrations:refresh');
    }
}
