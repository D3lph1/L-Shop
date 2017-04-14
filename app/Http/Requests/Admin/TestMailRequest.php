<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TestMailRequest extends FormRequest
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
            'test_mail_address' => 'required|email'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        $attribute = 'Адрес электронной почты, на который будет отправлено письмо';

        return [
            'test_mail_address.required' => trans('validation.required', ['attribute' => $attribute]),
            'test_mail_address.email' => trans('validation.email', ['attribute' => $attribute])
        ];
    }
}
