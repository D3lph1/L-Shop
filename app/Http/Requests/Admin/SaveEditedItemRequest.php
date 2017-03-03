<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SaveEditedItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'item_name' => 'required|min:3|max:64',
            'item_extra' => 'sometimes'
        ];
    }

    public function messages()
    {
        return [
            'item_name.required' => trans('validation.required', ['attribute' => 'Название предмета']),
            'item_name.min' => trans('validation.min.string', ['attribute' => 'Название предмета', 'min' => 3]),
            'item_name.max' => trans('validation.max.string', ['attribute' => 'Название предмета', 'max' => 64])
        ];
    }
}
