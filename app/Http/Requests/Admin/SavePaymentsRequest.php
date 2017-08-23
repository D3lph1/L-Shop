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

            'robokassa_login' => 'nullable',
            'robokassa_password1' => 'nullable',
            'robokassa_password2' => 'nullable',
            'robokassa_algo' => 'nullable',
            'robokassa_test' => 'boolean',

            'interkassa_checkout_id' => 'nullable',
            'interkassa_key' => 'nullable',
            'interkassa_test_key' => 'nullable',
            'interkassa_currency' => 'nullable',
            'interkassa_algo' => 'nullable',
            'interkassa_test' => 'boolean',
        ];
    }
}
