<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SaveChangedPasswordRequest extends FormRequest
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
            'password' => 'required|confirmed|min:4|max:191'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        $a = ['attribute' => 'Новый пароль'];

        return [
            'password.required' => trans('validation.required', $a),
            'password.confirmed' => trans('validation.confirmed', $a),
            'password.min' => trans('validation.required', $a),
            'password.max' => trans('validation.required', $a),
        ];
    }
}
