<?php
declare(strict_types = 1);

namespace App\Services\Item\Image\Hashing;

interface Hasher
{
    public function make(string $pathToFile);
}
