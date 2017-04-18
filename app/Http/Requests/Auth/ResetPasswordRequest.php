<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'password' => 'required|confirmed|max:191|min:' . config('l-shop.validation.password.min')
        ];
    }

    public function messages()
    {
        $password = ['attribute' => 'Новый пароль'];

        return [
            'password.required' => trans('validation.required', $password),
            'password.min' => trans('validation.min.string', $password),
            'password.max' => trans('validation.max.string', $password),
            'password.confirmed' => trans('validation.confirmed', $password)
        ];
    }
}
