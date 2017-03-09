<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RepeatSendActivationRequest extends FormRequest
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
            'email' => 'required|email'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => trans('validation.required', ['attribute' => 'Адрес электронной почты']),
            'email.email' => trans('validation.email', ['attribute' => 'Адрес электронной почты'])
        ];
    }
}
