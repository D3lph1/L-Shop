<?php
declare(strict_types = 1);

namespace App\Services\Database\Truncater;

interface Truncater
{
    /**
     * Produces cascading table truncation.
     *
     * @param string $entityClassName Name of the entity class of the table that you want to truncate.
     */
    public function truncate(string $entityClassName): void;
}
