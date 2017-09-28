<?php
declare(strict_types = 1);

namespace App\Models\Page;

use Carbon\Carbon;

/**
 * Interface PageInterface
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Models\Page
 */
interface PageInterface
{
    public function getId(): int;

    public function getTitle(): string;

    public function getContent(): string;

    public function getUrl(): string;

    public function getCreatedAt(): Carbon;

    public function getUpdatedAt(): ?Carbon;
}
