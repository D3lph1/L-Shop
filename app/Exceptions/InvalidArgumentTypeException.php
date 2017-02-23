<?php

namespace App\Exceptions;

/**
 * Class InvalidTypeArgumentException
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Exceptions
 */
class InvalidArgumentTypeException extends \InvalidArgumentException
{
    /**
     * @param string $expected
     * @param mixed $given
     * @internal param array|string $excpected
     */
    public function __construct($expected, $given)
    {
        $expected = $this->biuldExpected($expected);
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
    private function biuldExpected($data)
    {
        if (is_array($data)) {
            $content = '`' . implode('`, ', $data). '`';
            return $content;
        }
        return '`' . $data . '`';
    }
}
