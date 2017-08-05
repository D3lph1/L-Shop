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

            'interkassa_checkout_id' => 'required',
            'interkassa_key' => 'required',
            'interkassa_test_key' => 'required',
            'interkassa_currency' => 'nullable',
            'interkassa_algo' => 'required',
            'interkassa_test' => 'boolean',
        ];
    }
}
