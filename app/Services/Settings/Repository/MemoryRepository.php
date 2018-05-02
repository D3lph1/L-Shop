<?php
declare(strict_types=1);

namespace App\Services\Settings\Repository;

use App\Services\Settings\Setting;

/**
 * Class MemoryRepository
 * The repository stores settings using the array. Data is not saved between requests. Used for testing.
 */
class MemoryRepository implements Repository
{
    /**
     * @var Setting[]
     */
    private $memory = [];

    /**
     * @return Setting[]
     */
    public function findAll(): array
    {
        return $this->memory;
    }

    /**
     * {@inheritdoc}
     */
    public function create(Setting $setting): void
    {
        $this->memory[] = $setting;
    }

    /**
     * {@inheritdoc}
     */
    public function update(Setting $setting): void
    {
        foreach ($this->memory as $key => &$item) {
            if ($setting->getKey() === $item->getKey()) {
                $setting->generateUpdatedAt();
                $this->memory[$key] = $setting;

                return;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Setting $setting): void
    {
        foreach ($this->memory as $key => &$item) {
            if ($setting->getKey() === $item->getKey()) {
                unset($this->memory[$key]);

                return;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function deleteAll(): bool
    {
        $this->memory = [];

        return true;
    }
}
