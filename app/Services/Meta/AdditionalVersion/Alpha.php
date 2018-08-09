<?php
declare(strict_types = 1);

namespace App\Services\Meta\AdditionalVersion;

class Alpha implements AdditionalVersion
{
    /**
     * @var int
     */
    private $number;

    public function __construct(int $number)
    {
        $this->number = $number;
    }

    public function number(): int
    {
        return $this->number;
    }

    public function formatted(): string
    {
        return "alpha{$this->number()}";
    }
}
