<?php
declare(strict_types = 1);

namespace App\Services\Media\Character\Skin;

use App\Services\Media\Character\Skin\Applicators\Applicator;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

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

    public function front(?int $maxHeight = null): Image
    {
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

    public function back(?int $maxHeight = null): Image
    {
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

    private function resize(Image $canvas, int $maxHeight): void
    {
        $height = $this->applicator->height();
        $width = $this->applicator->width();

        $newHeight = $maxHeight;
        $newWidth = ($newHeight * $width) / $height;
        $canvas->resize($newWidth, $newHeight);
    }

    public function getApplicator(): Applicator
    {
        return $this->applicator;
    }
}
