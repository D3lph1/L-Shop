<?php
declare(strict_types = 1);

namespace App\Models\Category;

use App\Models\Server\ServerInterface;
use Carbon\Carbon;

interface CategoryInterface
{
    public function getServer(): ServerInterface;


    public function getId(): int;

    public function getName(): string;

    public function getServerId(): int;

    public function getCreatedAt(): Carbon;

    public function getUpdatedAt(): ?Carbon;
}
