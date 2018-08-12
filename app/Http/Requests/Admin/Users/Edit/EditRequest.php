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
            ->build();

        return [
            'username' => $usernameRules,
            'email' => 'required|email',
            'password' => $passwordRules,
            'balance' => 'required|numeric|min:0',
            'roles' => 'required|array',
            'permissions' => 'array'
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributes(): array
    {
        return [
            'password' => __('content.admin.users.edit.main.new_password'),
            'balance' => __('content.admin.users.edit.main.balance'),
            'roles' => __('content.admin.users.edit.main.roles'),
            'permissions' => __('content.admin.users.edit.main.permissions')
        ];
    }
}
