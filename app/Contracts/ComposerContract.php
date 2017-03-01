<?php

namespace App\Contracts;

use Illuminate\View\View;

/**
 * Interface ComposerContract
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Contracts
 */
interface ComposerContract
{
    public function compose(View $view);
}
