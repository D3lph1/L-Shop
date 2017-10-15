<?php
declare(strict_types = 1);

namespace App\Models\Item;

use Carbon\Carbon;

/**
 * Interface ItemInterface
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Models\Item
 */
interface ItemInterface
{
    public function setId(int $id): ItemInterface;

    public function getId(): ?int;

    public function setName(string $name): ItemInterface;

    public function getName(): string;

    public function setDescription(?string $description): ItemInterface;

    public function getDescription(): ?string;

    public function setType(string $type): ItemInterface;

    public function getType(): string;

    public function setItem(string $item): ItemInterface;

    public function getItem(): string;

    public function setImage(?string $image): ItemInterface;

    public function getImage(): ?string;

    public function setExtra(?string $extra): ItemInterface;

    public function getExtra(): ?string;

    public function getCreatedAt(): Carbon;

    public function getUpdatedAt(): ?Carbon;
}
