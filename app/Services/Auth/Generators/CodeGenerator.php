<?php
declare(strict_types = 1);

namespace App\Services\Auth\Generators;

/**
 * Interface CodeGenerator
 * The generator is used to generate various codes. for example, activation codes, password
 * recovery codes, etc.
 * It should be noted that the generation of codes should occur through the use of
 * cryptographically stable functions.
 */
interface CodeGenerator
{
    /**
     * Creates a cryptographically secure string of a given length.
     *
     * @param int $length
     *
     * @return string
     */
    public function generate(int $length): string;
}
