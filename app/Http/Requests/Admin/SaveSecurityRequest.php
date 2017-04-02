<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SaveSecurityRequest extends FormRequest
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
            'recaptcha_public_key' => 'required|size:40',
            'recaptcha_secret_key' => 'required|size:40',
            'enable_change_password' => 'boolean'
        ];
    }

    public function messages()
    {
        return [
            'recaptcha_public_key.required' => trans('validation.required', ['attribute' => 'Публичный ключ ReCAPTCHA']),
            'recaptcha_secret_key.required' => trans('validation.required', ['attribute' => 'Секретный ключ ReCAPTCHA']),
            'recaptcha_public_key.size' => trans('validation.size.string', ['attribute' => 'Публичный ключ ReCAPTCHA']),
            'recaptcha_secret_key.size' => trans('validation.size.string', ['attribute' => 'Публичный ключ ReCAPTCHA'])
        ];
    }
}
