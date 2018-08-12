<?php
declare(strict_types = 1);

namespace App\Services\Media\Character\Cloak;

use App\Services\Media\Character\Cloak\Applicators\Applicator;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

/**
 * Class Builder
 * Produces the construction of any part of the cloak from individual segments.
 */
class Builder
{
    /**
     * @var ImageManager
     */
    private $imageManager;

    /**
     * @var Applicator
     */
    private $applicator;

    public function __construct(ImageManager $imageManager, Applicator $applicator)
    {
        $this->imageManager = $imageManager;
        $this->applicator = $applicator;
    }

    /**
     * Produces the construction of the front of the cloak.
     *
     * @param int|null $maxHeight The maximum height of the cloak. If required, a resize to
     *                            the specified value will be made.
     *
     * @return Image
     */
    public function front(?int $maxHeight = null)
    {
        // Create a new canvas. In the future, it will be inserted segments.
        $canvas = $this->imageManager->canvas($this->applicator->width(), $this->applicator->height());
        $front = $this->applicator->front();
        $canvas->insert($front);

        if ($maxHeight !== null) {
            $this->resize($canvas, $maxHeight);
        }

        return $canvas;
    }

    /**
     * Produces the construction of the back of the cloak.
     *
     * @param int|null $maxHeight The maximum height of the cloak. If required, a resize to
     *                            the specified value will be made.
     *
     * @return Image
     */
    public function back(?int $maxHeight = null)
    {
        // Create a new canvas. In the future, it will be inserted segments.
        $canvas = $this->imageManager->canvas($this->applicator->width(), $this->applicator->height());
        $back = $this->applicator->back();
        $canvas->insert($back);

        if ($maxHeight !== null) {
            $this->resize($canvas, $maxHeight);
        }

        return $canvas;
    }

    /**
     * Produces a resize of the final image.
     *
     * @param Image $canvas
     * @param int   $maxHeight
     */
    private function resize(Image $canvas, int $maxHeight): void
    {
        $height = $this->applicator->height();
        $width = $this->applicator->width();

        $newHeight = $maxHeight;
        $newWidth = ($newHeight * $width) / $height;
        $canvas->resize($newWidth, $newHeight);
    }
}
