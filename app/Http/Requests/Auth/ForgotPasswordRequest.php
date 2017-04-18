<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
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
            'email' => 'required|email|min:4|max:191'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        $email = ['attribute' => 'Адрес электронной почты'];

        return [
            'email.required' => trans('validation.required', $email),
            'email.email' => trans('validation.email', $email),
            'email.min' => trans('validation.min.string', $email),
            'email.max' => trans('validation.max.string', $email)
        ];
    }
}
