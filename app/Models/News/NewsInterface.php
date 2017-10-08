<?php
declare(strict_types = 1);

namespace App\Models\News;

use App\Models\User\UserInterface;
use Carbon\Carbon;

/**
 * Interface NewsInterface
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Models\News
 */
interface NewsInterface
{
    public function getUser(): UserInterface;


    public function getId(): ?int;

    public function setTitle(string $title): NewsInterface;

    public function getTitle(): string;

    public function setContent(string $content): NewsInterface;

    public function getContent(): string;

    public function setUserId(int $userId): NewsInterface;

    public function getUserId(): int;

    public function getCreatedAt(): Carbon;

    public function getUpdatedAt(): ?Carbon;
}
