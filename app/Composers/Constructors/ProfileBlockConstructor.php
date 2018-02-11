<?php
declare(strict_types = 1);

namespace App\Composers\Constructors;

use App\Services\Settings\DataType;
use App\Services\Settings\Settings;

class ProfileBlockConstructor
{
    /**
     * @var Settings
     */
    private $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function construct(): array
    {
        $profile = [];
        if ($this->characterAvailable()) {
            array_push($profile, [
                'link' => route('frontend.profile.character.render'),
                'icon' => 'user',
                'caption' => __('sidebar.profile.character')
            ]);
        }
        array_push($profile, [
            'link' => '',
            'icon' => 'gear',
            'caption' => __('sidebar.profile.settings')
        ]);
        array_push($profile, [
            'caption' => __('sidebar.profile.information.name'),
            'icon' => 'info',
            'subItems' => [
                [
                    'link' => '',
                    'caption' => __('sidebar.profile.information.nodes.payments')
                ],
                [
                    'link' => '',
                    'caption' => __('sidebar.profile.information.nodes.cart')
                ]
            ]
        ]);

        return $profile;
    }

    private function characterAvailable(): bool
    {
        return $this->settings->get('system.profile.character.skin.enabled')->getValue(DataType::BOOL)
            || $this->settings->get('system.profile.character.cloak.enabled')->getValue(DataType::BOOL);
    }
}
