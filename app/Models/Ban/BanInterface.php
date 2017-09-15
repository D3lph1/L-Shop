<?php
declare(strict_types = 1);

namespace App\Models\Ban;

use Carbon\Carbon;

interface BanInterface
{
    public function getId(): int;

    public function getUserId(): int;

    public function getUntil(): ?Carbon;

    public function getReason(): ?string;
}
