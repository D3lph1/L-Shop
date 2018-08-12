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
            'currency' => 'required|min:1',
            'currency_html' => 'required|min:1',
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
            'interkassa_currency' => 'nullable',
            'interkassa_algorithm' => 'nullable|required_if:interkassa_enabled,true',
            'interkassa_test' => 'required|boolean',
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributes(): array
    {
        return [
            'min_fill_balance_sum' => __('content.admin.control.payments.min_fill_balance_sum'),
            'currency' => __('content.admin.control.payments.currency'),
            'currency_html' => __('content.admin.control.payments.currency_html'),

            'robokassa_enabled' => __('content.admin.control.payments.robokassa.enabled'),
            'robokassa_login' => __('content.admin.control.payments.robokassa.login'),
            'robokassa_payment_password' => __('content.admin.control.payments.robokassa.payment_password'),
            'robokassa_validation_password' => __('content.admin.control.payments.robokassa.validation_password'),
            'robokassa_algorithm' => __('content.admin.control.payments.robokassa.algorithm'),
            'robokassa_test' => __('content.admin.control.payments.robokassa.test'),

            'interkassa_enabled' => __('content.admin.control.payments.interkassa.enabled'),
            'interkassa_checkout_id' => __('content.admin.control.payments.interkassa.checkout_id'),
            'interkassa_key' => __('content.admin.control.payments.interkassa.key'),
            'interkassa_test_key' => __('content.admin.control.payments.interkassa.test_key'),
            'interkassa_currency' => __('content.admin.control.payments.interkassa.currency'),
            'interkassa_algorithm' => __('content.admin.control.payments.interkassa.algorithm'),
            'interkassa_test' => __('content.admin.control.payments.interkassa.test'),
        ];
    }
}
