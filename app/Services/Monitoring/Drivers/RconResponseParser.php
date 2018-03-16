<?php
declare(strict_types = 1);

namespace App\Services\Monitoring\Drivers;

use App\Services\Rcon\Colorizers\TrimColorizer;

class RconResponseParser
{
    /**
     * @var string
     */
    private $pattern;

    /**
     * @var TrimColorizer
     */
    private $colorizer;

    public function __construct(string $pattern, TrimColorizer $colorizer)
    {
        $this->pattern = $pattern;
        $this->colorizer = $colorizer;
    }

    public function parse(string $response): DTO
    {
        $response = $this->sanitize($response);
        preg_match($this->pattern, $response, $matches);

        if (!isset($matches['now']) || !isset($matches['total'])) {
            throw new ResponseParseException($response, $this->pattern);
        }

        return new DTO((int)$matches['now'], (int)$matches['total']);
    }

    private function sanitize(string $response): string
    {
        return $this->colorizer->colorize($response);
    }
}
