<?php
declare(strict_types = 1);

namespace App\Http\Requests\Admin\Users\Edit;

use App\Handlers\Admin\Users\Edit\AddBanHandler;
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
        $modeConcrete = AddBanHandler::MODE_CONCRETE;
        $modeDays = AddBanHandler::MODE_DAYS;

        return [
            'forever' => 'nullable|boolean',
            'mode' => "in:{$modeConcrete},{$modeDays}",
            'date_time' => "nullable",
            'days' => "nullable|required_if:mode,{$modeDays}|integer|min:1",
            'reason' => 'nullable'
        ];
    }
}
