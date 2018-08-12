<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions\Predicates;

/**
 * Class Regex
 * The class serves to link that the string is a regular expression.
 */
class Regex
{
    /**
     * @var string
     */
    private $regex;

    public function __construct(string $regex)
    {
        $this->regex = $regex;
    }

    public function getRegex(): string
    {
        return $this->regex;
    }
}
