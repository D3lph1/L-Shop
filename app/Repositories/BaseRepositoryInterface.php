<?php
declare(strict_types = 1);

namespace App\Repositories;

/**
 * Interface BaseRepositoryInterface
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Repositories
 */
interface BaseRepositoryInterface
{
    /**
     * Removes all rows from the table.
     */
    public function truncate(): void;
}
