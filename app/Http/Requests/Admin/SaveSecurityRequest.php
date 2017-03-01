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
            'recaptcha_secret_key' => 'required|size:40'
        ];
    }

    public function messages()
    {
        return [
            'recaptcha_public_key.required' => 'Поле "Публичный ключ ReCAPTCHA" обязательно для заполнения',
            'recaptcha_secret_key.required' => 'Поле "Секретный ключ ReCAPTCHA" обязательно для заполнения',
            'recaptcha_public_key.size' => 'Поле "Секретный ключ ReCAPTCHA" должно содержать :size символов',
            'recaptcha_secret_key.size' => 'Поле "Секретный ключ ReCAPTCHA" должно содержать :size символов',
        ];
    }
}
