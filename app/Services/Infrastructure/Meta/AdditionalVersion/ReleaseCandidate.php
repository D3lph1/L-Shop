<?php
declare(strict_types = 1);

namespace App\Services\Infrastructure\Meta\AdditionalVersion;

class ReleaseCandidate implements AdditionalVersion
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
        return "rc{$this->number()}";
    }
}
