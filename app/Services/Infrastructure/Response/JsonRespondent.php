<?php
declare(strict_types = 1);

namespace App\Services\Infrastructure\Response;

interface JsonRespondent
{
    public function response(): array;
}
