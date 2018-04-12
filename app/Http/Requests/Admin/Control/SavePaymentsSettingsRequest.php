<?php
declare(strict_types  = 1);

namespace App\Http\Requests\Admin\Control;

use Illuminate\Foundation\Http\FormRequest;

class SavePaymentsSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'min_fill_balance_sum' => 'required|numeric|min:0.01',
            'robokassa_enabled' => 'required|boolean',
            'robokassa_login' => 'nullable|required_if:robokassa_enabled,true',
            'robokassa_payment_password' => 'nullable|required_if:robokassa_enabled,true',
            'robokassa_validation_password' => 'nullable|required_if:robokassa_enabled,true',
            'robokassa_algorithm' => 'nullable|required_if:robokassa_enabled,true',
            'robokassa_test' => 'required|boolean',

            'interkassa_enabled' => 'required|boolean',
            'interkassa_checkout_id' => 'nullable|required_if:interkassa_enabled,true',
            'interkassa_key' => 'nullable|required_if:interkassa_enabled,true',
            'interkassa_test_key' => 'nullable|required_if:interkassa_enabled,true',
            'interkassa_currency' => 'nullable|required_if:interkassa_enabled,true',
            'interkassa_algorithm' => 'nullable|required_if:interkassa_enabled,true',
            'interkassa_test' => 'required|boolean',
        ];
    }
}
