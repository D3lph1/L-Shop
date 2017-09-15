<?php
declare(strict_types = 1);

namespace App\Models\Page;

use Carbon\Carbon;

interface PageInterface
{
    public function getId(): int;

    public function getTitle(): string;

    public function getContent(): string;

    public function getUrl(): string;

    public function getCreatedAt(): Carbon;

    public function getUpdatedAt(): ?Carbon;
}
