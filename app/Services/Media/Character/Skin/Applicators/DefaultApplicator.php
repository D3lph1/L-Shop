<?php
declare(strict_types=1);

namespace App\Services\Media\Character\Skin\Applicators;

use Intervention\Image\Image;

/**
 * Class DefaultApplicator
 * Applicator cuts the original skin image into parts.
 */
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

    /**
     * {@inheritdoc}
     */
    public function headFront(): Image
    {
        return $this->cutSegment($this->segment, $this->segment);
    }

    /**
     * {@inheritdoc}
     */
    public function headBack(): Image
    {
        return $this->cutSegment($this->segment * 3, $this->segment);
    }

    /**
     * {@inheritdoc}
     */
    public function headLeft(): Image
    {
        return $this->cutSegment($this->segment * 2, $this->segment);
    }

    /**
     * {@inheritdoc}
     */
    public function headRight(): Image
    {
        return $this->cutSegment(0, $this->segment);
    }

    /**
     * {@inheritdoc}
     */
    public function headTop(): Image
    {
        return $this->cutSegment($this->segment, 0);
    }

    /**
     * {@inheritdoc}
     */
    public function headBottom(): Image
    {
        return $this->cutSegment($this->segment * 2, 0);
    }

    /**
     * {@inheritdoc}
     */
    public function leftLegFront(): Image
    {
        return $this->rightLegFront()->flip('h');
    }

    /**
     * {@inheritdoc}
     */
    public function leftLegBack(): Image
    {
        return $this->rightLegBack()->flip('h');
    }

    /**
     * {@inheritdoc}
     */
    public function leftLegLeft(): Image
    {
        return $this->rightLegRight()->flip('h');
    }

    /**
     * {@inheritdoc}
     */
    public function leftLegRight(): Image
    {
        return $this->rightLegLeft()->flip('h');
    }

    /**
     * {@inheritdoc}
     */
    public function leftLegTop(): Image
    {
        return $this->rightLegTop()->flip('h');
    }

    /**
     * {@inheritdoc}
     */
    public function leftLegBottom(): Image
    {
        return $this->rightLegBottom()->flip('h');
    }


    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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


    /**
     * {@inheritdoc}
     */
    public function leftArmFront(): Image
    {
        return $this->rightArmFront()->flip('h');
    }

    /**
     * {@inheritdoc}
     */
    public function leftArmBack(): Image
    {
        return $this->rightArmBack()->flip('h');
    }

    /**
     * {@inheritdoc}
     */
    public function leftArmLeft(): Image
    {
        return $this->rightArmLeft()->flip('h');
    }

    /**
     * {@inheritdoc}
     */
    public function leftArmRight(): Image
    {
        return $this->rightArmLeft()->flip('h');
    }

    /**
     * {@inheritdoc}
     */
    public function leftArmTop(): Image
    {
        return $this->rightArmTop()->flip('h');
    }

    /**
     * {@inheritdoc}
     */
    public function leftArmBottom(): Image
    {
        return $this->rightArmBottom()->flip('h');
    }


    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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


    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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


    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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


    /**
     * {@inheritdoc}
     */
    public function width(): int
    {
        return $this->segment * 2;
    }

    /**
     * {@inheritdoc}
     */
    public function height(): int
    {
        return $this->segment * 4;
    }

    /**
     * {@inheritdoc}
     */
    private function cutSegment(int $x, int $y): Image
    {
        $c = clone $this->canvas;

        return $c->crop($this->segment, $this->segment, $x, $y);
    }
}
