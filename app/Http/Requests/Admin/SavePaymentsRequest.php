<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SavePaymentsRequest extends FormRequest
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
            'min_sum' => 'required|numeric|min:1',
            'currency' => 'required|min:1',
            'currency_html' => 'required|min:1',
            'robokassa_login' => 'required',
            'robokassa_password1' => 'required',
            'robokassa_password2' => 'required',
            'robokassa_algo' => 'required',
            'robokassa_test' => 'boolean',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'min_sum.required' => trans('validation.required', ['attribute' => 'Минимальная сумма пополнения баланса']),
            'min_sum.numeric' => trans('validation.numeric', ['attribute' => 'Минимальная сумма пополнения баланса']),
            'min_sum.min' => trans('validation.min', ['attribute' => 'Минимальная сумма пополнения баланса']),
            'currency.required' => trans('validation.required', ['attribute' => 'Название валюты']),
            'currency.min' => trans('validation.min', ['attribute' => 'Название валюты']),
            'currency_html.required' => trans('validation.required', ['attribute' => 'HTML представление валюты']),
            'currency_html.min' => trans('validation.min', ['attribute' => 'HTML представление валюты']),
            'robokassa_login.required' => trans('validation.required', ['attribute' => 'Robkassa. Логин']),
            'robokassa_password1.required' => trans('validation.required', ['attribute' => 'Robkassa. Пароль №1']),
            'robokassa_password2.required' => trans('validation.required', ['attribute' => 'Robkassa. Пароль №2']),
            'robokassa_algo.required' => trans('validation.required', ['attribute' => 'Robkassa. Алгоритм расчета контрольной суммы']),
            'robokassa_test.boolean' => trans('validation.boolean', ['attribute' => 'Robokassa. Тестовый режим']),
        ];
    }
}
