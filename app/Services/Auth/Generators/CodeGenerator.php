<?php
declare(strict_types = 1);

namespace App\Services\Auth\Generators;

interface CodeGenerator
{
    public function generate(int $length);
}
