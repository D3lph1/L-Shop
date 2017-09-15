<?php
declare(strict_types = 1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ResetPasswordRequest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Requests\Auth
 */
class ResetPasswordRequest extends FormRequest
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
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|confirmed|max:191|min:' . config('l-shop.validation.password.min')
        ];
    }
}
