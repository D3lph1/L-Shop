<?php
declare(strict_types = 1);

namespace App\Models\Ban;

use Carbon\Carbon;

/**
 * Interface BanInterface
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Models\Ban
 */
interface BanInterface
{
    public function getId(): int;

    public function setUserId(int $id): BanInterface;

    public function getUserId(): int;

    public function setUntil(Carbon $until): BanInterface;

    public function getUntil(): ?Carbon;

    public function setReason(string $reason): BanInterface;

    public function getReason(): ?string;
}
