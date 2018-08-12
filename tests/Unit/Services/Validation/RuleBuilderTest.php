<?php
declare(strict_types = 1);

namespace Tests\Unit\Services\Validation;

use App\Services\Validation\Rule;
use App\Services\Validation\RulesBuilder;
use Tests\TestCase;

class RuleBuilderTest extends TestCase
{
    public function testBuild()
    {
        $builder = new RulesBuilder();
        $rules = $builder
            ->addRule(new Rule('required'))
            ->addRule(new Rule('min', 5))
            ->addRule(new Rule('unique', ['email', 'users']))
            ->build();

        $expected = 'required|min:5|unique:email,users';
        self::assertEquals($expected, $rules);
    }
}
