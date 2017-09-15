<?php
declare(strict_types = 1);

namespace App\Models\News;

use App\Models\User\UserInterface;
use Carbon\Carbon;

interface NewsInterface
{
    public function getUser(): UserInterface;


    public function getId(): int;

    public function getTitle(): string;

    public function getContent(): string;

    public function getUserId(): int;

    public function getCreatedAt(): Carbon;

    public function getUpdatedAt(): ?Carbon;
}
