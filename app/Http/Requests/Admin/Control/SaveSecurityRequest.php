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
            'recaptcha_public_key' => 'required|string|size:40',
            'recaptcha_secret_key' => 'required|string|size:40',
            'reset_password_enabled' => 'required|boolean',
            'change_password_enabled' => 'required|boolean'
        ];
    }
}
