<?php
declare(strict_types = 1);

namespace App\Services\Meta;

use App\Services\Meta\AdditionalVersion\Beta;

/**
 * This class contains metadata about L-Shop system.
 * It is not intended for editing. Please do not change it.
 */
final class System
{
    /**
     * @var Version|null
     */
    private static $version = null;

    /**
     * Returns the version object that contains the current version of L-Shop.
     *
     * @return Version
     */
    public static function version(): Version
    {
        if (self::$version === null) {
            self::$version = new Version(1, 1, 0);
        }

        return self::$version;
    }

    public static function githubRepositoryUrl(): string
    {
        return 'https://github.com/D3lph1/L-shop';
    }

    public static function documentationUrL(): string
    {
        return 'https://github.com/D3lph1/L-shop/wiki';
    }

    /**
     * Returns array of information about L-Shop developers.
     *
     * @return Developer[]
     */
    public static function developers(): array
    {
        return [
            new Developer(
                'D3lph1',
                __('content.admin.information.about.developers.D3lph1.name'),
                __('content.admin.information.about.developers.D3lph1.description.plain'),
                [
                    'vk' => 'https://vk.com/d3lph1',
                    'rubukkit' => 'http://rubukkit.org/members/d3lph1.94641/',
                    'github' => 'https://github.com/D3lph1'
                ],
                asset('img/layout/admin/developers/D3lph1.png')
            ),
            new Developer(
                'WhileD0S',
                __('content.admin.information.about.developers.WhileD0S.name'),
                __('content.admin.information.about.developers.WhileD0S.description.plain'),
                [
                    'vk' => 'https://vk.com/whiled0s'
                ],
                asset('img/layout/admin/developers/WhileD0S.png')
            )
        ];
    }
}
