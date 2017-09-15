<?php
declare(strict_types = 1);

namespace App\Traits;

use Illuminate\Container\Container;
use Illuminate\Foundation\Application;

trait ContainerTrait
{
    protected function getContainer()
    {
        return Container::getInstance();
    }

    protected function make(string $abstract)
    {
        return $this->getContainer()->make($abstract);
    }

    protected function makeWith(string $abstract, array $parameters)
    {
        return $this->getContainer()->make($abstract, $parameters);
    }

    protected function getApp(): Application
    {
        return $this->make(Application::class);
    }
}
