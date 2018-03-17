<?php
declare(strict_types = 1);

namespace App\Http\Requests\Admin\Users\Edit;

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
        return [
            'forever' => 'nullable|boolean',
            'date_time' => 'nullable|required_unless:forever,true',
            'reason' => 'nullable'
        ];
    }
}
