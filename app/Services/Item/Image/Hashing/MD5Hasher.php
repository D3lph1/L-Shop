<?php
declare(strict_types = 1);

namespace App\Services\Item\Image\Hashing;

/**
 * Class MD5Hasher
 * Implementing the hash of item image files based on the MD5 algorithm.
 */
class MD5Hasher implements Hasher
{
    /**
     * {@inheritdoc}
     */
    public function make(string $pathToFile): string
    {
        return md5_file($pathToFile);
    }
}
