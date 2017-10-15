<?php
declare(strict_types = 1);

namespace App\Contracts;

use Illuminate\View\View;

/**
 * Interface ComposerContract
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Contracts
 */
interface ComposerContract
{
    /**
     * Compose the view.
     *
     * @param View $view
     */
    public function compose(View $view): void;
}
