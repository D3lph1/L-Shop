<?php
/**
 * @link
 * @copyright
 * @license
 */

namespace App\Exceptions;


class InvalidTypeArgumentException extends \InvalidArgumentException
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
            '"' . gettype($given) . '"'
        ));
    }
    /**
     * @param string|array $data
     * @return string
     */
    private function biuldExpected($data)
    {
        if (is_array($data)) {
            $count = count($data);
            $i = 0;
            $content = '';
            foreach ($data as $item) {
                if ($i == $count - 1)
                    $content .= '"' . $item . '"';
                else
                    $content .= '"' . $item . '" or ';
                $i++;
            }
            return $content;
        }
        return '"' . $data . '"';
    }
}
