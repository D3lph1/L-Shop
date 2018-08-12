<?php
declare(strict_types = 1);

namespace App\Http\Requests\Admin\Users\Edit;

use App\Handlers\Admin\Users\Edit\AddBanHandler;
use App\Services\Validation\Rule;
use App\Services\Validation\RulesBuilder;
use Illuminate\Foundation\Http\FormRequest;

class AddBanRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        $modeDays = AddBanHandler::MODE_DAYS;

        return [
            'forever' => 'nullable|boolean',
            'mode' => (new RulesBuilder())
                ->addRule(new Rule('in', [AddBanHandler::MODE_CONCRETE, $modeDays]))
                ->build(),
            'date_time' => "nullable",
            'days' => "nullable|required_if:mode,{$modeDays}|integer|min:1",
            'reason' => 'nullable'
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributes(): array
    {
        return [
            'forever' => __('content.admin.users.edit.actions.add_ban.forever'),
            'date_time' => __('content.admin.users.edit.actions.add_ban.datetime'),
            'days' => __('content.admin.users.edit.actions.add_ban.days'),
            'reason' => __('content.admin.users.edit.actions.add_ban.reason')
        ];
    }
}
