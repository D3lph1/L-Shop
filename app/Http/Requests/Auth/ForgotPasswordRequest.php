<?php
declare(strict_types = 1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ForgotPasswordRequest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Requests\Auth
 */
class ForgotPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|min:4|max:191'
        ];
    }
}
