<?php
declare(strict_types = 1);

use Illuminate\Database\Seeder;

/**
 * Class SettingsSeeder
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 */
class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $config = config('default');
        ksort($config);
        s_set($config);
        s_set([
            'shop.currency' => __('seeding.settings.currency'),
            'shop.currency_html' => __('seeding.settings.currency_html'),
            'shop.description' => __('seeding.settings.description'),
            'shop.keywords' => __('seeding.settings.keywords'),
            'api.launcher.sashok.auth.error_message' => __('seeding.settings.sashok_auth_error_message')
        ]);
        s_save();
    }
}
