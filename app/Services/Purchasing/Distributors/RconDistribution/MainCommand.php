<?php
declare(strict_types = 1);

namespace App\Services\Purchasing\Distributors\RconDistribution;

class MainCommand
{
    /**
     * @var string
     */
    private $command;

    /**
     * @var string|null
     */
    private $responsePattern;

    public function __construct(string $command, ?string $responsePattern)
    {
        $this->command = $command;
        $this->responsePattern = $responsePattern;
    }

    /**
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * @return null|string
     */
    public function getResponsePattern(): ?string
    {
        return $this->responsePattern;
    }
}
