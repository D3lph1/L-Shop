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
        //В IOC-контейнере создаем(если есть получаем) экземпляр класса Doctrine, возвращаем объект и начинаем транзакцию к БД
        $this->app->make(EntityManagerInterface::class)->beginTransaction();
    }

    protected function rollback(): void
    {
        //В IOC-контейнере создаем(если есть получаем) экземпляр класса Doctrine, возвращаем объект и откатываем транзакцию к БД
        $this->app->make(EntityManagerInterface::class)->rollback();
    }

    protected function authAdmin(): void
    {
        //Производим легкую аудентификацию от имени admin
        $this->app->make(Auth::class)->authenticate('admin', 'admin');
    }
}
