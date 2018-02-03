<?php
declare(strict_types=1);

namespace App\Services\Settings\Repository;

use App\Services\Settings\Setting;

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

    public function create(Setting $setting): void
    {
        $this->memory[] = $setting;
    }

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

    public function delete(Setting $setting): void
    {
        foreach ($this->memory as $key => &$item) {
            if ($setting->getKey() === $item->getKey()) {
                unset($this->memory[$key]);

                return;
            }
        }
    }

    public function deleteAll(): bool
    {
        $this->memory = [];

        return true;
    }
}
