<?php
declare(strict_types = 1);

namespace App\Http\Requests\Admin\Users\Edit;

use App\Services\Validation\Rule;
use App\Services\Validation\RulesBuilder;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param Repository $config
     *
     * @return array
     */
    public function rules(Repository $config): array
    {
        $usernameRules = (new RulesBuilder())
            ->addRule(new Rule('required'))
            ->addRule(new Rule('string'))
            ->addRule(new Rule('min', $config->get('auth.validation.username.min')))
            ->addRule(new Rule('max', $config->get('auth.validation.username.max')))
            ->addRule(new Rule($config->get('auth.validation.username.rule')))
            ->build();

        $passwordRules = (new RulesBuilder())
            ->addRule(new Rule('nullable'))
            ->addRule(new Rule('string'))
            ->addRule(new Rule('min', $config->get('auth.validation.password.min')))
            ->addRule(new Rule('max', $config->get('auth.validation.password.max')))
            ->addRule(new Rule('confirmed'))
            ->build();

        return [
            'username' => $usernameRules,
            'email' => 'required|email',
            'password' => $passwordRules,
            'roles' => 'required|array',
            'permissions' => 'array'
        ];
    }
}
