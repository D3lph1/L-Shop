<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SaveEditedServerRequest extends FormRequest
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
            'categories.*.*' => 'required|min:2|max:32',
            'enabled' => 'boolean',
            'server_ip' => 'ip',
            'server_port' => 'integer',
            'server_password' => 'max:64',
            'server_monitoring_enabled' => 'boolean'
        ];
    }

    public function messages()
    {
        return [
            'categories.*.*.required' => trans('validation.required', ['attribute' => 'Имя категории']),
            'categories.*.*.min' => trans('validation.min.string', ['attribute' => 'Имя категории'])
        ];
    }
}
