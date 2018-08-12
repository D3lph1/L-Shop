<?php
declare(strict_types = 1);

namespace App\Services\Auth\Generators;

/**
 * Interface CodeGenerator
 * The generator is used to generate various codes. for example, activation codes, password
 * recovery codes, etc.
 * It should be noted that the generation of codes should occur through the use of
 * cryptographically safe functions.
 */
interface CodeGenerator
{
    /**
     * Creates a cryptographically safe string of a given length.
     *
     * @param int $length Length of the generated key.
     *
     * @return string Generated key.
     */
    public function generate(int $length): string;
}
