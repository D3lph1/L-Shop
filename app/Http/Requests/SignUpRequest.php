<?php
declare(strict_types = 1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SignUpRequest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Requests
 */
class SignUpRequest extends FormRequest
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
        $rule = config('l-shop.validation.username.rule');
        $rule = $rule ? '|' . $rule : '';

        return [
            'username' =>"required|min:" . config('l-shop.validation.username.min') . "|max:" . config('l-shop.validation.username.max') . "{$rule}",
            'email' => 'required|email|min:4|max:191',
            'password' => 'required|confirmed|max:191|min:' . config('l-shop.validation.password.min')
        ];
    }
}
