<?php
declare(strict_types = 1);

namespace App\Services\Auth\Generators;

class DefaultCodeGenerator implements CodeGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generate(int $length): string
    {
        return str_random($length);
    }
}
