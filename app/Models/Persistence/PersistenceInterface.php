<?php
declare(strict_types = 1);

namespace App\Models\Persistence;

use Carbon\Carbon;

/**
 * Interface PersistenceInterface
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Models\Persistence
 */
interface PersistenceInterface extends \Cartalyst\Sentinel\Persistences\PersistenceInterface
{
    public function setUserId(int $userId): PersistenceInterface;

    public function getUserId(): int;

    public function setCode(string $code): PersistenceInterface;

    public function getCode(): string ;

    public function getCreatedAt(): Carbon;

    public function getUpdatedAt(): ?Carbon;
}
