<?php
declare(strict_types = 1);

namespace App\Composers;

use App\Services\Settings\DataType;
use App\Services\Settings\Settings;
use Illuminate\Contracts\Config\Repository;
use Illuminate\View\View;

class GlobalLayoutComposer
{
    /**
     * @var Repository
     */
    private $config;

    /**
     * @var Settings
     */
    private $settings;

    public function __construct(Repository $config, Settings $settings)
    {
        $this->config = $config;
        $this->settings = $settings;
    }

    public function compose(View $view): void
    {
        $view->with($this->getData());
    }

    private function getData(): array
    {
        return [
            'baseUrl' => $this->config->get('app.url'),
            'baseUrlPath' => parse_url($this->config->get('app.url'), PHP_URL_PATH),
            'title' => $this->settings->get('shop.name')->getValue(),
            'description' => $this->settings->get('shop.description')->getValue(),
            'keywords' => $this->settings->get('shop.keywords')->getValue(),
            'captchaEnabled' => $this->settings->get('system.security.captcha.enabled')->getValue(DataType::BOOL)
        ];
    }
}
