<?php
declare(strict_types = 1);

namespace App\Services\Media\Character\Skin;

use App\Services\Media\Character\Skin\Applicators\Applicator;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

/**
 * Class Builder
 * Produces the construction of any part of the skin from individual segments.
 */
class Builder
{
    /**
     * @var Applicator
     */
    private $applicator;

    /**
     * @var ImageManager
     */
    private $manager;

    public function __construct(ImageManager $manager, Applicator $applicator)
    {
        $this->manager = $manager;
        $this->applicator = $applicator;
    }

    /**
     * Produces the construction of the front of the skin.
     *
     * @param int|null $maxHeight The maximum height of the skin. If required, a resize to
     *                            the specified value will be made.
     *
     * @return Image
     */
    public function front(?int $maxHeight = null): Image
    {
        // Create a new canvas. In the future, it will be inserted segments.
        $canvas = $this->manager->canvas($this->applicator->width(), $this->applicator->height());
        $head = $this->applicator->headFront();
        $canvas->insert($head, 'top-left', $head->width() / 2, 0);

        $rightArm = $this->applicator->rightArmFront();
        $canvas->insert($rightArm, 'top-left', 0, $head->width());

        $body = $this->applicator->bodyFront();
        $canvas->insert($body, 'top-left', $rightArm->width(), $head->height());

        $leftArm = $this->applicator->leftArmFront();
        $canvas->insert($leftArm, 'top-left', $rightArm->width() + $body->width(), $head->height());

        $rightLeg = $this->applicator->rightLegFront();
        $canvas->insert($rightLeg, 'top-left', $rightArm->width(), $head->height() + $body->height());

        $leftLeg = $this->applicator->leftLegFront();
        $canvas->insert($leftLeg, 'top-left', $rightArm->width() + $rightLeg->width(), $head->height() + $body->height());

        if ($maxHeight !== null) {
            $this->resize($canvas, $maxHeight);
        }

        return $canvas;
    }

    /**
     * Produces the construction of the back of the skin.
     *
     * @param int|null $maxHeight The maximum height of the skin. If required, a resize to
     *                            the specified value will be made.
     *
     * @return Image
     */
    public function back(?int $maxHeight = null): Image
    {
        // Create a new canvas. In the future, it will be inserted segments.
        $canvas = $this->manager->canvas($this->applicator->width(), $this->applicator->height());
        $head = $this->applicator->headBack();
        $canvas->insert($head, 'top-left', $head->width() / 2, 0);

        $leftArm = $this->applicator->leftArmBack();
        $canvas->insert($leftArm, 'top-left', 0, $head->width());

        $body = $this->applicator->bodyBack();
        $canvas->insert($body, 'top-left', $leftArm->width(), $head->height());

        $rightArm = $this->applicator->rightArmBack();
        $canvas->insert($rightArm, 'top-left', $leftArm->width() + $body->width(), $head->height());

        $leftLeg = $this->applicator->leftLegBack();
        $canvas->insert($leftLeg, 'top-left', $leftArm->width(), $head->height() + $body->height());

        $rightLeg = $this->applicator->rightLegBack();
        $canvas->insert($rightLeg, 'top-left', $leftArm->width() + $leftLeg->width(), $head->height() + $body->height());

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
