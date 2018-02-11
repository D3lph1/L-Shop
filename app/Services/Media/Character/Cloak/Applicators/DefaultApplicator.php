<?php
declare(strict_types = 1);

namespace App\Services\Media\Character\Cloak\Applicators;

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
    private $ratio;

    public function __construct(Image $canvas)
    {
        $this->canvas = $canvas;

        $this->ratio = (int)($this->canvas->width() / 64);
        $validWidth = 0;
        $validHeight = 0;

        if ($this->ratio != 0) {
            $validWidth = $this->canvas->width() / $this->ratio === 64;
            $validHeight = $this->canvas->height() / $this->ratio === 32;
        }

        if (!($validWidth && $validHeight)) {
            $this->ratio = (int)($this->canvas->width() / 17);

            $validWidth = $this->canvas->width() / $this->ratio === 22;
            $validHeight = $this->canvas->height() / $this->ratio === 17;
        }
    }

    public function front(): Image
    {
        $c = clone $this->canvas;

        return $c->crop(10 * $this->ratio, 16 * $this->ratio, $this->ratio, $this->ratio);
    }

    public function back(): Image
    {
        $c = clone $this->canvas;

        return $c->crop(10 * $this->ratio, 17 * $this->ratio, $this->ratio + 11 * $this->ratio, $this->ratio);
    }

    public function edge(): Image
    {
        $c = clone $this->canvas;
    }

    public function width(): int
    {
        return $this->ratio * 10;
    }

    public function height(): int
    {
        return $this->ratio * 16;
    }
}
