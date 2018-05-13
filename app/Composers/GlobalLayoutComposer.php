<?php
declare(strict_types = 1);

namespace App\Composers;

use App\Services\Settings\Settings;
use Illuminate\View\View;

class GlobalLayoutComposer
{
    /**
     * @var Settings
     */
    private $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function compose(View $view): void
    {
        $view->with($this->getData());
    }

    private function getData(): array
    {
        return [
            'title' => $this->settings->get('shop.name')->getValue(),
            'description' => $this->settings->get('shop.description')->getValue(),
            'keywords' => $this->settings->get('shop.keywords')->getValue()
        ];
    }
}
