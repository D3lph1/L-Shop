<?php
declare(strict_types = 1);

namespace App\Http\Requests\Admin\Control;

use Illuminate\Foundation\Http\FormRequest;

class SaveSecurityRequest extends FormRequest
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
            'captcha_enabled' => 'required|boolean',
            'recaptcha_public_key' => 'nullable|required_if:captcha_enabled,true|string|size:40',
            'recaptcha_secret_key' => 'nullable|required_if:captcha_enabled,true|string|size:40',
            'reset_password_enabled' => 'required|boolean',
            'change_password_enabled' => 'required|boolean'
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributes(): array
    {
        return [
            'captcha_enabled' => __('content.admin.control.security.recaptcha.enabled'),
            'recaptcha_public_key' => __('content.admin.control.security.recaptcha.public_key'),
            'recaptcha_secret_key' => __('content.admin.control.security.recaptcha.secret_key'),
            'reset_password_enabled' => __('content.admin.control.security.reset_password_enabled'),
            'change_password_enabled' => __('content.admin.control.security.change_password_enabled')
        ];
    }
}
