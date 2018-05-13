<?php
declare(strict_types = 1);

namespace App\Services\Database\Transfer;

/**
 * Interface Transfer
 * Contains the logic for moving data from the old version of the system to a new one.
 */
interface Transfer
{
    /**
     * Moves data.
     *
     * @param string $from (Database name)/(table prefix) from which the import will be made.
     * @param string $to (Database name)/(table prefix) of the tables to be exported.
     */
    public function transfer(string $from, string $to): void;
}
