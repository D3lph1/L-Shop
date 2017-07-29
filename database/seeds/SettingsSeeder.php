<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        s_set(config('default'));
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
