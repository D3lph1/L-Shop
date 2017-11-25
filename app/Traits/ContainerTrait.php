<?php
declare(strict_types = 1);

namespace App\Traits;

use Illuminate\Container\Container;
use Illuminate\Foundation\Application;

/**
 * Trait ContainerTrait
 * Helps to work quickly with a service-container.
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Traits
 */
trait ContainerTrait
{
    protected function getContainer()
    {
        return Container::getInstance();
    }

    /**
     * Helper for Container::getInstance()->make().
     */
    protected function make(string $abstract)
    {
        return $this->getContainer()->make($abstract);
    }

    /**
     * Helper for Container::getInstance()->makeWith().
     */
    protected function makeWith(string $abstract, array $parameters)
    {
        return $this->getContainer()->make($abstract, $parameters);
    }

    protected function getApp(): Application
    {
        return $this->make(Application::class);
    }
}
