<?php
declare(strict_types = 1);

namespace App\Services\Media\Character\Cloak\Applicators;

use Intervention\Image\Image;

interface Applicator
{
    public function front(): Image;

    public function back(): Image;

    public function edge(): Image;

    public function width(): int;

    public function height(): int;
}
