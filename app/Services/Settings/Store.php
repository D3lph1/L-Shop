<?php
declare(strict_types = 1);

namespace App\Services\Settings;

/**
 * Class Store
 * Represents a local configuration store. The data here live during the query.
 */
class Store
{
    /**
     * @var Setting[]
     */
    private $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function get(string $key): ?Setting
    {
        foreach ($this->data as $datum) {
            if ($key === $datum->getKey()) {
                return $datum;
            }
        }

        return null;
    }

    public function set(string $key, $value): void
    {
        foreach ($this->data as $datum) {
            if ($key === $datum->getKey()) {
                $datum->setValue($value);
                return;
            }
        }

        $this->data[] = new Setting($key, $value);
    }

    public function remove(string $key): bool
    {
        foreach ($this->data as $k => &$value) {
            if ($key === $value->getKey()) {
                unset($this->data[$k]);
                return true;
            }
        }

        return false;
    }

    public function exists(string $key): bool
    {
        foreach ($this->data as $k => $value) {
            if ($key === $value->getKey()) {
                return true;
            }
        }

        return false;
    }

    public function flush(): void
    {
        $this->data = [];
    }

    public function all(): array
    {
        return $this->data;
    }
}
