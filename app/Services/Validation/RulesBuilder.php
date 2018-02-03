<?php
declare(strict_types = 1);

namespace App\Services\Validation;

class RulesBuilder
{
    /**
     * @var Rule[]
     */
    private $rules = [];

    public function addRule(Rule $rule): RulesBuilder
    {
        $this->rules[] = $rule;

        return $this;
    }

    public function build(): string
    {
        $result = [];
        foreach ($this->rules as $rule) {
            if (count($rule->getValues()) === 0) {
                $result[] = $rule->getName();
            } else {
                $values = implode(',', $rule->getValues());
                $result[] = "{$rule->getName()}:{$values}";
            }
        }

        return implode('|', $result);
    }
}
