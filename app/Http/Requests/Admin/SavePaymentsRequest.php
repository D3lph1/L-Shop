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
        $minSum = ['attribute' => 'Минимальная сумма пополнения баланса'];

        return [
            'min_sum.required' => trans('validation.required', $minSum),
            'min_sum.numeric' => trans('validation.numeric', $minSum),
            'min_sum.min' => trans('validation.min', $minSum),
        ];
    }
}
