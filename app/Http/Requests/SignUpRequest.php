<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
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
        $rule = config('l-shop.validation.username.rule');
        $rule = $rule ? '|' . $rule : '';

        return [
            'username' =>"required|min:" . config('l-shop.validation.username.min') . "|max:" . config('l-shop.validation.username.max') . "{$rule}",
            'email' => 'required|email|min:4|max:191',
            'password' => 'required|confirmed|max:191|min:' . config('l-shop.validation.password.min') . ''
        ];
    }

    /***
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => trans('validation.required', ['attribute' => 'Имя пользователя']),
            'username.min' => trans('validation.min.string', ['attribute' => 'Имя пользователя']),
            'username.max' => trans('validation.max.string', ['attribute' => 'Имя пользователя']),
            'username.alpha_dash' => trans('validation.alpha_dash', ['attribute' => 'Имя пользователя']),
            'username.regex' => trans('validation.regex', ['attribute' => 'Имя пользователя']),

            'email.required' => trans('validation.required', ['attribute' => 'Адрес электронной почты']),
            'email.unique' => trans('validation.unique', ['attribute' => 'Адрес электронной почты']),
            'email.min' => trans('validation.min.string', ['attribute' => 'Адрес электронной почты']),
            'email.max' => trans('validation.max.string', ['attribute' => 'Адрес электронной почты']),

            'password.required' => trans('validation.required', ['attribute' => 'Пароль']),
            'password.min' => trans('validation.min.string', ['attribute' => 'Пароль']),
            'password.max' => trans('validation.max.string', ['attribute' => 'Пароль']),
            'password.confirmed' => trans('validation.confirmed', ['attribute' => 'Пароль'])
        ];
    }
}
