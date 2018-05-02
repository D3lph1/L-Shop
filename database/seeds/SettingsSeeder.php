<?php
declare(strict_types = 1);

use App\Services\Settings\Settings;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(Settings $settings, Repository $config): void
    {
        $settings->flush();
        $settings->save();

        $data = $config->get('default');
        $data = $this->localize($data);

        $settings->setArray($data);
        $settings->save();
    }

    /**
     * Localizes the configuration by replacing strings starting with $: by the value from
     * the localization file (seeding.php).
     *
     * @param array $data
     *
     * @return array
     */
    private function localize(array $data): array
    {
        foreach ($data as $key => &$value) {
            if (is_array($value)) {
                $value = $this->localize($value);
                continue;
            }

            if (is_string($value) && mb_strpos($value, '$:') === 0) {
                $value = mb_substr($value, 2);
                $value = __("seeding.{$value}");
            }
        }

        return $data;
    }
}
