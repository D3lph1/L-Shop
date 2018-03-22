<?php
declare(strict_types = 1);

namespace App\Services\Validation;

/**
 * Class RulesBuilder
 * This class is building a rule string for the native Laravel validator. It is convenient
 * to use it when specifying a complex set of rules.
 *
 * @example
 *  $builder = new RulesBuilder();
 *  $builder->addRule(new Rule('required'))
 *          ->addRule(new Rule('mime-types', ['png', 'jpg']));
 *  $result = $builder->build(); // `required|mime-types:png,jpg`
 */
class RulesBuilder
{
    /**
     * Set of rules (builder state).
     *
     * @var Rule[]
     */
    private $rules = [];

    /**
     * Add new rule to builder state.
     *
     * @param Rule $rule
     *
     * @return RulesBuilder
     */
    public function addRule(Rule $rule): RulesBuilder
    {
        $this->rules[] = $rule;

        return $this;
    }

    /**
     * Convert builder state to stringed rule representation.
     *
     * @return string
     */
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
