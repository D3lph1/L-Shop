<?php

namespace App\Exceptions;

/**
 * Class InvalidTypeArgumentException
 * An exception is thrown if the arguments passed to a function or method have an extraneous type.
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Exceptions
 */
class InvalidArgumentTypeException extends \InvalidArgumentException
{
    /**
     * @param string|array $expected
     * @param mixed $given
     * @internal param array|string $excpected
     */
    public function __construct($expected, $given)
    {
        $expected = $this->buildExpected($expected);
        parent::__construct(sprintf(
            'Expected argument type(s): %s, %s given',
            $expected,
            '`' . gettype($given) . '`'
        ));
    }
    /**
     * @param string|array $data
     * @return string
     */
    private function buildExpected($data)
    {
        if (is_array($data)) {
            $content = '`' . implode('`, ', $data). '`';
            return $content;
        }
        return '`' . $data . '`';
    }
}
