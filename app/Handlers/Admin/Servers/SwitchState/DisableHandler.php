<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Servers\SwitchState;

class DisableHandler extends AbstractHandler
{
    protected function enabled(): bool
    {
        return false;
    }
}
