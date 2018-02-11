<?php
declare(strict_types = 1);

namespace App\Services\Media\Character\Skin\Applicators;

use Intervention\Image\Image;

interface Applicator
{
    public function headFront(): Image;

    public function headBack(): Image;

    public function headLeft(): Image;

    public function headRight(): Image;

    public function headTop(): Image;

    public function headBottom(): Image;


    public function leftLegFront(): Image;

    public function leftLegBack(): Image;

    public function leftLegLeft(): Image;

    public function leftLegRight(): Image;

    public function leftLegTop(): Image;

    public function leftLegBottom(): Image;


    public function rightLegFront(): Image;

    public function rightLegBack(): Image;

    public function rightLegLeft(): Image;

    public function rightLegRight(): Image;

    public function rightLegTop(): Image;

    public function rightLegBottom(): Image;


    public function leftArmFront(): Image;

    public function leftArmBack(): Image;

    public function leftArmLeft(): Image;

    public function leftArmRight(): Image;

    public function leftArmTop(): Image;

    public function leftArmBottom(): Image;


    public function rightArmFront(): Image;

    public function rightArmBack(): Image;

    public function rightArmLeft(): Image;

    public function rightArmRight(): Image;

    public function rightArmTop(): Image;

    public function rightArmBottom(): Image;


    public function bodyFront(): Image;

    public function bodyBack(): Image;

    public function bodyLeft(): Image;

    public function bodyRight(): Image;

    public function bodyTop(): Image;

    public function bodyBottom(): Image;


    public function width(): int;

    public function height(): int;
}
