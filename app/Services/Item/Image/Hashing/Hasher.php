<?php
declare(strict_types = 1);

namespace App\Services\Item\Image\Hashing;

/**
 * Interface Hasher
 * Interface for hash files. It is used to hash the downloaded user item images.
 *
 * <p>Subsequently, the downloaded files are renamed to the hash calculated here.
 * This is done in order to bring the filename to a consistent form, as well as
 * to avoid storing the same files, since when loading them the hashes will
 * match and only one of them will get to the disk.</p>
 */
interface Hasher
{
    /**
     * Calculates the checksum of the image file and returns it.
     *
     * @param string $pathToFile The path to the file whose checksum must be calculated.
     *
     * @return string Calculated checksum (hash).
     */
    public function make(string $pathToFile): string;
}
