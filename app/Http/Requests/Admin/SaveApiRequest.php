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
            'signin_enabled' => 'boolean',
            'signin_remember' => 'boolean'
        ];
    }

    public function messages()
    {
        return [
            'key.required' => 'Поле "Ключ доступа" обязательно для заполнения',
            'key.min' => 'Поле "Ключ доступа" не должно быть короче 32 символов',
            'key.max' => 'Поле "Ключ доступа" не должно быть длиннее 1024 символов',
            'key.algo' => 'Поле "Алгоритм хэширования" обязательно для заполнения'
        ];
    }
}
