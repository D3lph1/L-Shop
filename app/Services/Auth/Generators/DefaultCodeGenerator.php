<?php
declare(strict_types = 1);

namespace App\Services\Auth\Generators;

class DefaultCodeGenerator implements CodeGenerator
{
    public function generate(int $length)
    {
        return str_random($length);
    }
}
