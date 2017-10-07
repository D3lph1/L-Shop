<?php
declare(strict_types = 1);

namespace App\Models\Category;

use App\Models\Server\ServerInterface;
use Carbon\Carbon;

/**
 * Interface CategoryInterface
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Models\Category
 */
interface CategoryInterface
{
    public function getServer(): ServerInterface;


    public function setId(int $id): CategoryInterface;

    public function getId(): ?int;

    public function setName(string $name): CategoryInterface;

    public function getName(): string;

    public function setServerId(int $id): CategoryInterface;

    public function getServerId(): int;

    public function getCreatedAt(): Carbon;

    public function getUpdatedAt(): ?Carbon;
}
