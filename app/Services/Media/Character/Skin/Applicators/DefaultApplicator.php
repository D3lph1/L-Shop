<?php
declare(strict_types=1);

namespace App\Services\Media\Character\Skin\Applicators;

use Intervention\Image\Image;

class DefaultApplicator implements Applicator
{
    /**
     * @var Image
     */
    private $canvas;

    /**
     * @var int
     */
    private $segment;

    /**
     * @var int
     */
    private $smallSegment;

    public function __construct(Image $canvas)
    {
        $this->canvas = $canvas;
        $this->segment = $canvas->height() / 4;
        $this->smallSegment = $canvas->height() / 8;
    }

    public function headFront(): Image
    {
        return $this->cutSegment($this->segment, $this->segment);
    }

    public function headBack(): Image
    {
        return $this->cutSegment($this->segment * 3, $this->segment);
    }

    public function headLeft(): Image
    {
        return $this->cutSegment($this->segment * 2, $this->segment);
    }

    public function headRight(): Image
    {
        return $this->cutSegment(0, $this->segment);
    }

    public function headTop(): Image
    {
        return $this->cutSegment($this->segment, 0);
    }

    public function headBottom(): Image
    {
        return $this->cutSegment($this->segment * 2, 0);
    }

    public function leftLegFront(): Image
    {
        return $this->rightLegFront()->flip('h');
    }

    public function leftLegBack(): Image
    {
        return $this->rightLegBack()->flip('h');
    }

    public function leftLegLeft(): Image
    {
        return $this->rightLegRight()->flip('h');
    }

    public function leftLegRight(): Image
    {
        return $this->rightLegLeft()->flip('h');
    }

    public function leftLegTop(): Image
    {
        return $this->rightLegTop()->flip('h');
    }

    public function leftLegBottom(): Image
    {
        return $this->rightLegBottom()->flip('h');
    }


    public function rightLegFront(): Image
    {
        $c = clone $this->canvas;

        return $c->crop(
            $this->smallSegment,
            $this->segment + $this->smallSegment,
            $this->smallSegment,
            $this->segment * 2 + $this->smallSegment
        );
    }

    public function rightLegBack(): Image
    {
        $c = clone $this->canvas;

        return $c->crop(
            $this->smallSegment,
            $this->segment + $this->smallSegment,
            $this->segment + $this->smallSegment,
            $this->segment * 2 + $this->smallSegment
        );
    }

    public function rightLegLeft(): Image
    {
        $c = clone $this->canvas;

        return $c->crop(
            $this->smallSegment,
            $this->segment + $this->smallSegment,
            $this->segment,
            $this->segment * 2 + $this->smallSegment
        );
    }

    public function rightLegRight(): Image
    {
        $c = clone $this->canvas;

        return $c->crop(
            $this->smallSegment,
            $this->segment + $this->smallSegment,
            0,
            $this->segment * 2 + $this->smallSegment
        );
    }

    public function rightLegTop(): Image
    {
        $c = clone $this->canvas;

        return $c->crop(
            $this->smallSegment,
            $this->smallSegment,
            $this->smallSegment,
            $this->segment * 2
        );
    }

    public function rightLegBottom(): Image
    {
        $c = clone $this->canvas;

        return $c->crop(
            $this->smallSegment,
            $this->smallSegment,
            $this->segment,
            $this->segment * 2
        );
    }


    public function leftArmFront(): Image
    {
        return $this->rightArmFront()->flip('h');
    }

    public function leftArmBack(): Image
    {
        return $this->rightArmBack()->flip('h');
    }

    public function leftArmLeft(): Image
    {
        return $this->rightArmLeft()->flip('h');
    }

    public function leftArmRight(): Image
    {
        return $this->rightArmLeft()->flip('h');
    }

    public function leftArmTop(): Image
    {
        return $this->rightArmTop()->flip('h');
    }

    public function leftArmBottom(): Image
    {
        return $this->rightArmBottom()->flip('h');
    }


    public function rightArmFront(): Image
    {
        $c = clone $this->canvas;

        return $c->crop(
            $this->smallSegment,
            $this->segment + $this->smallSegment,
            $this->segment * 5 + $this->smallSegment,
            $this->segment * 2 + $this->smallSegment
        );
    }

    public function rightArmBack(): Image
    {
        $c = clone $this->canvas;

        return $c->crop(
            $this->smallSegment,
            $this->segment + $this->smallSegment,
            $this->segment * 6 + $this->smallSegment,
            $this->segment * 2 + $this->smallSegment
        );
    }

    public function rightArmLeft(): Image
    {
        $c = clone $this->canvas;

        return $c->crop(
            $this->smallSegment,
            $this->segment + $this->smallSegment,
            $this->segment * 6,
            $this->segment * 2 + $this->smallSegment
        );
    }

    public function rightArmRight(): Image
    {
        $c = clone $this->canvas;

        return $c->crop(
            $this->smallSegment,
            $this->segment + $this->smallSegment,
            $this->segment * 5,
            $this->segment * 2 + $this->smallSegment
        );
    }

    public function rightArmTop(): Image
    {
        $c = clone $this->canvas;

        return $c->crop(
            $this->smallSegment,
            $this->smallSegment,
            $this->segment * 5 + $this->smallSegment,
            $this->segment * 2
        );
    }

    public function rightArmBottom(): Image
    {
        $c = clone $this->canvas;

        return $c->crop(
            $this->smallSegment,
            $this->smallSegment,
            $this->segment * 6,
            $this->segment * 2
        );
    }


    public function bodyFront(): Image
    {
        $c = clone $this->canvas;

        return $c->crop(
            $this->segment,
            $this->segment + $this->smallSegment,
            $this->segment * 2 + $this->smallSegment,
            $this->segment * 2 + $this->smallSegment
        );
    }

    public function bodyBack(): Image
    {
        $c = clone $this->canvas;

        return $c->crop(
            $this->segment,
            $this->segment + $this->smallSegment,
            $this->segment *  4,
            $this->segment * 2 + $this->smallSegment
        );
    }

    public function bodyLeft(): Image
    {
        $c = clone $this->canvas;

        return $c->crop(
            $this->smallSegment,
            $this->segment + $this->smallSegment,
            $this->segment *  3 + $this->smallSegment,
            $this->segment * 2 + $this->smallSegment
        );
    }

    public function bodyRight(): Image
    {
        $c = clone $this->canvas;

        return $c->crop(
            $this->smallSegment,
            $this->segment + $this->smallSegment,
            $this->segment *  2,
            $this->segment * 2 + $this->smallSegment
        );
    }


    public function bodyTop(): Image
    {
        $c = clone $this->canvas;

        return $c->crop(
            $this->segment,
            $this->smallSegment,
            $this->segment * 2 + $this->smallSegment,
            $this->segment * 2
        );
    }

    public function bodyBottom(): Image
    {
        $c = clone $this->canvas;

        return $c->crop(
            $this->segment,
            $this->smallSegment,
            $this->segment * 3 + $this->smallSegment,
            $this->segment * 2
        );
    }


    public function width(): int
    {
        return $this->segment * 2;
    }

    public function height(): int
    {
        return $this->segment * 4;
    }

    private function cutSegment(int $x, int $y): Image
    {
        $c = clone $this->canvas;

        return $c->crop($this->segment, $this->segment, $x, $y);
    }
}
