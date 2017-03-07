<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SaveEditedUserRequest extends FormRequest
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
            'username' => 'required',
            'email' => 'required',
            'balance' => 'required|numeric|min:0,01',
            'admin' => 'boolean',
            'password' => 'sometimes'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => trans('validation.required', ['attribute' => 'Имя пользователя']),
            'email.required' => trans('validation.required', ['attribute' => 'Почта']),
            'balance.required' => trans('validation.required', ['attribute' => 'Баланс']),
            'balance.numeric' => trans('validation.numeric', ['attribute' => 'Баланс']),
            'balance.min' => trans('validation.min.numeric', ['attribute' => 'Баланс'])
        ];
    }
}
