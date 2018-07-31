<?php
declare(strict_types = 1);

namespace App\Services\Settings;

/**
 * Class Settings
 * Works with the application's configurable settings.
 *
 * <p>Note that all changes made by calling the {@see Settings::set()}, {@see Settings::setArray()},
 * {@see Settings::forget()}, {@see Settings::flush()} methods only affect the local storage.
 * That is, these changes are not saved between requests. In order to save the settings to
 * a permanent store, you must save them in the {@see Settings::save()} method.</p>
 */
interface Settings
{
    /**
     * Gets the setting with the specified key. If it does not exist, it returns the default value.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return Setting|mixed
     */
    public function get(string $key, $default = null);

    /**
     * Deletes the setting with the specified key.
     *
     * @param string $key
     *
     * @return bool
     */
    public function forget(string $key): bool;

    /**
     * Adds the setting, converting it before saving it into a data type that is convenient for
     * storage. If the configuration with the specified key already exists, it updates it.
     *
     * @param string $key
     * @param        $value
     */
    public function set(string $key, $value): void;

    /**
     * One-time set all the settings from the array. The array has the format: settings_key => setting_value.
     *
     * @param array $data
     */
    public function setArray(array $data): void;

    public function exists(string $key): bool;

    public function flush(): void;

    public function save(): void;
}
