<?php
declare(strict_types = 1);

namespace App\Models\Item;

use Carbon\Carbon;

interface ItemInterface
{
    public function getId(): int;

    public function getName(): string;

    public function getDescription(): ?string;

    public function getType(): string;

    public function getItem(): string;

    // TODO: Create class for image.
    public function getImage(): ?string;

    public function getExtra(): ?string;

    public function getCreatedAt(): Carbon;

    public function getUpdatedAt(): ?Carbon;
}
