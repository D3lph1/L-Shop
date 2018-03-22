<?php
declare(strict_types = 1);

namespace App\Services\Media\Character\Skin\Applicators;

use Intervention\Image\Image;

/**
 * Interface Applicator
 * Applicator cuts the original skin image into parts.
 */
interface Applicator
{
    /**
     * Front side of skin head.
     *
     * @return Image
     */
    public function headFront(): Image;

    /**
     * Back side of skin head.
     *
     * @return Image
     */
    public function headBack(): Image;

    /**
     * Left side of skin head.
     *
     * @return Image
     */
    public function headLeft(): Image;

    /**
     * Right side of skin head
     *
     * @return Image
     */
    public function headRight(): Image;

    /**
     * Top side of skin head.
     *
     * @return Image
     */
    public function headTop(): Image;

    /**
     * Bottom side of skin head
     *
     * @return Image
     */
    public function headBottom(): Image;


    /**
     * Front side of left leg.
     *
     * @return Image
     */
    public function leftLegFront(): Image;

    /**
     * Back side of left leg.
     *
     * @return Image
     */
    public function leftLegBack(): Image;

    /**
     * Left side of left leg.
     *
     * @return Image
     */
    public function leftLegLeft(): Image;

    /**
     * Right side of left leg.
     *
     * @return Image
     */
    public function leftLegRight(): Image;

    /**
     * Top side of left leg.
     *
     * @return Image
     */
    public function leftLegTop(): Image;

    /**
     * Bottom side of left leg.
     *
     * @return Image
     */
    public function leftLegBottom(): Image;


    /**
     * Front side of right leg.
     *
     * @return Image
     */
    public function rightLegFront(): Image;

    /**
     * Back side of right leg.
     *
     * @return Image
     */
    public function rightLegBack(): Image;

    /**
     * Left side of right leg.
     *
     * @return Image
     */
    public function rightLegLeft(): Image;

    /**
     * Right side of right leg.
     *
     * @return Image
     */
    public function rightLegRight(): Image;

    /**
     * Top side of right leg.
     *
     * @return Image
     */
    public function rightLegTop(): Image;

    /**
     * Bottom side of right leg.
     *
     * @return Image
     */
    public function rightLegBottom(): Image;


    /**
     * Front side of left arm.
     *
     * @return Image
     */
    public function leftArmFront(): Image;

    /**
     * Back side of left arm.
     *
     * @return Image
     */
    public function leftArmBack(): Image;

    /**
     * Left side of left arm.
     *
     * @return Image
     */
    public function leftArmLeft(): Image;

    /**
     * Right side of left arm.
     *
     * @return Image
     */
    public function leftArmRight(): Image;

    /**
     * Top side of left arm.
     *
     * @return Image
     */
    public function leftArmTop(): Image;

    /**
     * Bottom side of left arm.
     *
     * @return Image
     */
    public function leftArmBottom(): Image;


    /**
     * Front side of right arm.
     *
     * @return Image
     */
    public function rightArmFront(): Image;

    /**
     * Back side of right arm.
     *
     * @return Image
     */
    public function rightArmBack(): Image;

    /**
     * Left side of right arm.
     *
     * @return Image
     */
    public function rightArmLeft(): Image;

    /**
     * Right side of right arm.
     *
     * @return Image
     */
    public function rightArmRight(): Image;

    /**
     * Top side of right arm.
     *
     * @return Image
     */
    public function rightArmTop(): Image;

    /**
     * Bottom side of right arm.
     *
     * @return Image
     */
    public function rightArmBottom(): Image;


    /**
     * Front side of body.
     *
     * @return Image
     */
    public function bodyFront(): Image;

    /**
     * Back side of body.
     *
     * @return Image
     */
    public function bodyBack(): Image;

    /**
     * Left side of body.
     *
     * @return Image
     */
    public function bodyLeft(): Image;

    /**
     * Right side of body.
     *
     * @return Image
     */
    public function bodyRight(): Image;

    /**
     * Top side of body.
     *
     * @return Image
     */
    public function bodyTop(): Image;

    /**
     * Bottom side of body.
     *
     * @return Image
     */
    public function bodyBottom(): Image;


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
