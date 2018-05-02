<?php
declare(strict_types = 1);

namespace App\Services\Settings;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

/**
 * Class Settings
 * Works with the application's configurable settings.
 *
 * <p>Note that all changes made by calling the {@see Settings::set()}, {@see Settings::setArray()},
 * {@see Settings::forget()}, {@see Settings::flush()} methods only affect the local storage.
 * That is, these changes are not saved between requests. In order to save the settings to
 * a permanent store, you must save them in the {@see Settings::save()} method.</p>
 */
class Settings
{
    /**
     * @var Driver
     */
    private $driver;

    /**
     * @var Store
     */
    private $store;

    /**
     * @var Setting[]
     */
    private $originalData;

    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
        $this->originalData = $driver->read();

        $new = [];
        foreach ($this->originalData as $originalDatum) {
            $new[] = clone $originalDatum;
        }
        // Create store with array with cloned elements.
        $this->store = new Store($new);
    }

    /**
     * Gets the setting with the specified key. If it does not exist, it returns the default value.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return Setting|mixed
     */
    public function get(string $key, $default = null)
    {
        if ($this->exists($key)) {
            return $this->store->get($key);
        }

        return $default;
    }

    /**
     * Deletes the setting with the specified key.
     *
     * @param string $key
     *
     * @return bool
     */
    public function forget(string $key): bool
    {
        return $this->store->remove($key);
    }

    /**
     * Adds the setting, converting it before saving it into a data type that is convenient for
     * storage. If the configuration with the specified key already exists, it updates it.
     *
     * @param string $key
     * @param        $value
     */
    public function set(string $key, $value): void
    {
        if ($value instanceof \JsonSerializable) {
            $value = json_encode($value);
        }
        if ($value instanceof Jsonable) {
            $value = $value->toJson();
        }
        if ($value instanceof Arrayable) {
            $value = $value->toArray();
        }
        if ($value instanceof \Serializable || is_object($value)) {
            $value = serialize($value);
        }
        if (is_array($value)) {
            $value = json_encode($value);
        }
        if (is_bool($value)) {
            $value = (int)$value;
        }

        $this->store->set($key, $value);
    }

    /**
     * One-time set all the settings from the array. The array has the format: settings_key => setting_value.
     *
     * @param array $data
     */
    public function setArray(array $data): void
    {
        $data = array_dot($data);
        foreach ($data as $key => $value) {
            $this->set($key, $value);
        }
    }

    public function exists(string $key): bool
    {
        return $this->store->exists($key);
    }

    public function flush(): void
    {
        $this->store->flush();
    }

    public function save(): void
    {
        $this->driver->write($this->originalData, $this->store->all());
        $this->originalData = $this->store->all();
    }
}
