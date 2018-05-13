<?php
declare(strict_types = 1);

namespace App\Services\Meta\AdditionalVersion;

interface AdditionalVersion
{
    public function number(): int;

    public function formatted(): string;
}
