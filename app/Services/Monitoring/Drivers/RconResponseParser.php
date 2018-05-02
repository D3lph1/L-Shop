<?php
declare(strict_types = 1);

namespace App\Services\Monitoring\Drivers;

use App\Services\Rcon\Colorizers\StripColorizer;

/**
 * Class RconResponseParser
 * It parses the result string from the driver. The task of the parser is to find in the line
 * by the given pattern the number with the current online and the number with the total
 * number of server slots.
 */
class RconResponseParser
{
    /**
     * @var string
     */
    private $pattern;

    /**
     * @var StripColorizer
     */
    private $colorizer;

    public function __construct(string $pattern, StripColorizer $colorizer)
    {
        $this->pattern = $pattern;
        $this->colorizer = $colorizer;
    }

    /**
     * Process parsing response.
     *
     * @param string $response
     *
     * @return DTO
     */
    public function parse(string $response): DTO
    {
        $response = $this->sanitize($response);
        preg_match($this->pattern, $response, $matches);

        if (!isset($matches['now']) || !isset($matches['total'])) {
            throw new ResponseParseException($response, $this->pattern);
        }

        return new DTO((int)$matches['now'], (int)$matches['total']);
    }

    /**
     * Clears the line from minecraft markup
     *
     * @param string $response Raw string.
     *
     * @return string Sanitized string.
     */
    private function sanitize(string $response): string
    {
        return $this->colorizer->colorize($response);
    }
}
