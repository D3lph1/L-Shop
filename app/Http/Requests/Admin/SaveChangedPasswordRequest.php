<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SaveChangedPasswordRequest extends FormRequest
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
            'password' => 'required|confirmed|min:4|max:191'
        ];
    }

    public function messages()
    {
        return [
            'password.required' => trans('validation.required', ['attribute' => 'Новый пароль']),
            'password.confirmed' => trans('validation.confirmed', ['attribute' => 'Новый пароль']),
            'password.min' => trans('validation.required', ['attribute' => 'Новый пароль', 'min' => 4]),
            'password.max' => trans('validation.required', ['attribute' => 'Новый пароль', 'max' => 191]),
        ];
    }
}
