<?php
declare(strict_types = 1);

namespace App\Services\Validation;

class Rule
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $values;

    /**
     * Rule constructor.
     *
     * @param string $name
     * @param integer|float|string|array  $values
     */
    public function __construct(string $name, $values = [])
    {
        $this->name = $name;
        if (is_array($values)) {
            $this->values = $values;
        } else {
            $this->values[] = $values;
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }
}
