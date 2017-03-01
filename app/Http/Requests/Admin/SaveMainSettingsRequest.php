<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SaveMainSettingsRequest extends FormRequest
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
            'shop_name' => 'required|min:2|max:128',
            'shop_description' => 'sometimes',
            'shop_keywords' => 'sometimes',
            'maintenance' => 'boolean'
        ];
    }

    public function messages()
    {
        return [
            'shop_name.required' => 'Поле "Имя магазина" обязательно для заполнения',
            'shop_name.min' => 'Значение поля "Имя магазина" слишком короткое',
            'shop_name.max' => 'Значение поля "Имя магазина" слишком длинное'
        ];
    }
}
