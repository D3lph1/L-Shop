<?php
declare(strict_types = 1);

namespace App\Services\Database\GarbageCollection;

/**
 * Interface GarbageCollector
 * Responsible for the release of internal (inside the application) repository.
 */
interface GarbageCollector
{
    /**
     * Completely clean the internal storage.
     */
    public function collectAll(): void;

    /**
     * Removes from the repository only the given entity.
     *
     * @param $entity
     */
    public function collectEntity($entity): void;
}
