<?php
declare(strict_types = 1);

namespace App\Exceptions;

use Throwable;

class InvalidArgumentTypeException extends InvalidArgumentException
{
    public function __construct($argument, $expected, $given, Throwable $previous = null)
    {
        if (is_array($expected)) {
            $expected = $this->build($expected);
        }
        $given = gettype($given);
        $message = "Argument `{$argument}` must be type of {$expected}; {$given} given.";

        parent::__construct($message, 0, $previous);
    }

    private function build(array $expected): string
    {
        $len = count($expected);
        $result = '';
        for ($i = 0; $i < $len; $i++) {
            $result .= $expected[$i];
            if ($i !== $len - 1) {
                $result .= ', ';
            }
        }

        return $result;
    }
}
