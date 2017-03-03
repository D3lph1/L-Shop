<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SaveAddedServerRequest extends FormRequest
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
            'server_name' => 'required|min:2|max:32',
            'categories' => 'required|array',
            'categories.*' => 'required|min:2|max:32',
            'enabled' => 'boolean'
        ];
    }

    public function messages()
    {
        return [
            'server_name.required' => trans('validation.required', ['attribute' => 'Имя сервера']),
            'server_name.min' => trans('validation.required', ['attribute' => 'Имя сервера']),
            'server_name.max' => trans('validation.required', ['attribute' => 'Имя сервера']),
            'categories.*.required' => trans('validation.required', ['attribute' => 'Имя категории']),
            'categories.*.*.min' => trans('validation.min.string', ['attribute' => 'Имя категории'])
        ];
    }
}
