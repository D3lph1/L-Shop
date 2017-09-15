<?php
declare(strict_types = 1);

namespace App\Models\Cart;

use Carbon\Carbon;

interface CartInterface
{
    public function getId(): int;

    public function getPlayer(): string;

    public function getType(): string;

    public function getItem(): string;

    public function getAmount(): int;

    public function getExtra(): ?string;

    public function getItemId(): int;

    public function getServerId(): int;

    public function getCreatedAt(): Carbon;

    public function getUpdatedAt(): ?Carbon;
}
