<?php

namespace App\Composers;

use Illuminate\View\View;
use App\Contracts\ComposerContract;

/**
 * Class GlobalLayoutComposer
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Composers
 */
class GlobalLayoutComposer implements ComposerContract
{
    /**
     * Compose the view
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with($this->getData());
    }

    /**
     * @return array
     */
    private function getData()
    {
        return [
            'shopDescription' => s_get('shop.description'),
            'shopKeywords' => s_get('shop.keywords')
        ];
    }
}