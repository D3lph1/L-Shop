<?php
declare(strict_types = 1);

namespace App\Services\Settings\Repository;

use App\Services\Settings\Setting;

/**
 * Interface Repository
 * The repository interacts with the settings store. Performs CRUD actions.
 */
interface Repository
{
    /**
     * Gets all the settings from the repository.
     *
     * @return Setting[]
     */
    public function findAll(): array;

    /**
     * Creates a new setting in the repository.
     *
     * @param Setting $setting
     */
    public function create(Setting $setting): void;

    /**
     * Updates an existing setting in the repository.
     *
     * @param Setting $setting
     */
    public function update(Setting $setting): void;

    /**
     * Removes a setting from the repository.
     *
     * @param Setting $setting
     */
    public function remove(Setting $setting): void;

    /**
     * Completely clean the storage by removing all settings.
     *
     * @return bool
     */
    public function deleteAll(): bool;
}
