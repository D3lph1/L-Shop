<?php
declare(strict_types = 1);

namespace App\Services\Media\Character\Cloak\Applicators;

use Intervention\Image\Image;

/**
 * Interface Applicator
 * Applicator cuts the original cloak image into parts.
 */
interface Applicator
{
    /**
     * Front side of cloak.
     *
     * @return Image
     */
    public function front(): Image;

    /**
     * Back side of cloak.
     *
     * @return Image
     */
    public function back(): Image;

    /**
     * Width of image.
     *
     * @return int
     */
    public function width(): int;

    /**
     * Height of image.
     *
     * @return int
     */
    public function height(): int;
}
