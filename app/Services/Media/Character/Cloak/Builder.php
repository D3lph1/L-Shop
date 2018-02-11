<?php
declare(strict_types = 1);

namespace App\Services\Media\Character\Cloak;

use App\Services\Media\Character\Cloak\Applicators\Applicator;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

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

    public function front(?int $maxHeight = null)
    {
        $canvas = $this->imageManager->canvas($this->applicator->width(), $this->applicator->height());
        $front = $this->applicator->front();
        $canvas->insert($front);

        if ($maxHeight !== null) {
            $this->resize($canvas, $maxHeight);
        }

        return $canvas;
    }

    public function back(?int $maxHeight = null)
    {
        $canvas = $this->imageManager->canvas($this->applicator->width(), $this->applicator->height());
        $back = $this->applicator->back();
        $canvas->insert($back);

        if ($maxHeight !== null) {
            $this->resize($canvas, $maxHeight);
        }

        return $canvas;
    }

    private function resize(Image $canvas, int $maxHeight): void
    {
        $height = $this->applicator->height();
        $width = $this->applicator->width();

        $newHeight = $maxHeight;
        $newWidth = ($newHeight * $width) / $height;
        $canvas->resize($newWidth, $newHeight);
    }
}
