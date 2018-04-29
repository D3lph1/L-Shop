<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Servers\SwitchState;

class EnableHandler extends AbstractHandler
{
    protected function enabled(): bool
    {
        return true;
    }
}
