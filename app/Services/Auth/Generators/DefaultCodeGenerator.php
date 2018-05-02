<?php
declare(strict_types = 1);

namespace App\Services\Auth\Generators;

/**
 * Class DefaultCodeGenerator
 * Produces the key generation with the built-in Laravel function, based on the cryptographically
 * safe function {@see random_bytes()}.
 */
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
