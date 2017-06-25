<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
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
        $rule = config('l-shop.validation.username.rule');
        $rule = $rule ? '|' . $rule : '';

        return [
            'username' =>"required|min:" . config('l-shop.validation.username.min') . "|max:" . config('l-shop.validation.username.max') . "{$rule}",
            'email' => 'required|email|min:4|max:191',
            'password' => 'required|confirmed|max:191|min:' . config('l-shop.validation.password.min')
        ];
    }
}
