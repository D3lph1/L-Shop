<?php
declare(strict_types = 1);

namespace App\Models\Cart;

use App\Models\Item\ItemInterface;
use Carbon\Carbon;

/**
 * Interface CartInterface
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Models\Cart
 */
interface CartInterface
{
    public function getRelatedItem(): ItemInterface;


    public function getId(): int;

    public function setPlayer(string $player): CartInterface;

    public function getPlayer(): string;

    public function setType(string $type): CartInterface;

    public function getType(): string;

    public function setItem(string $item): CartInterface;

    public function getItem(): string;

    public function setAmount(int $amount): CartInterface;

    public function getAmount(): int;

    public function setExtra(string $extra): CartInterface;

    public function getExtra(): ?string;

    public function setItemId(int $id): CartInterface;

    public function getItemId(): int;

    public function setServerId(int $id): CartInterface;

    public function getServerId(): int;

    public function getCreatedAt(): Carbon;

    public function getUpdatedAt(): ?Carbon;
}
