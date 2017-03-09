<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SaveApiRequest extends FormRequest
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
            'api_enabled' => 'boolean',
            'key' => 'required|min:32|max:1024',
            'algo' => 'required',
            'separator' => 'required',
            'salt' => 'boolean',
            'signin_enabled' => 'boolean',
            'signin_remember' => 'boolean'
        ];
    }

    public function messages()
    {
        return [
            'key.required' => trans('validation.required', ['attribute' => 'Ключ доступа']),
            'key.min' => trans('validation.min', ['attribute' => 'Ключ доступа']),
            'key.max' => trans('validation.max', ['attribute' => 'Ключ доступа']),
            'key.algo' => trans('validation.required', ['attribute' => 'Алгоритм хэширования']),
            'separator.required' => trans('validation.required', ['attribute' => 'Разделитель'])
        ];
    }
}
