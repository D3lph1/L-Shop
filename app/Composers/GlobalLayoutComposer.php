<?php
declare(strict_types = 1);

namespace App\Composers;

use App\Services\Settings\Settings;
use Illuminate\View\View;

class GlobalLayoutComposer
{
    public function compose(View $view): void
    {
        $view->with($this->getData());
    }

    private function getData(): array
    {
        $settings = app(Settings::class);

        return [
            'title' => $settings->get('shop.name')->getValue(),
            'description' => $settings->get('shop.description')->getValue(),
            'keywords' => $settings->get('shop.keywords')->getValue()
        ];
    }
}
