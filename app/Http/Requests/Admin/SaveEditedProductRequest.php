<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SaveEditedProductRequest extends FormRequest
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
            'item' => 'required|numeric',
            'stack' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:0.01',
            'server' => 'required|numeric',
            'category' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'stack.required' => trans('validation.required', ['attribute' => 'Количество товара в 1 стаке']),
            'stack.numeric' => trans('validation.numeric', ['attribute' => 'Количество товара в 1 стаке']),
            'price.required' => trans('validation.required', ['attribute' => 'Цена за стак товара']),
            'price.numeric' => trans('validation.numeric', ['attribute' => 'Цена за стак товара']),
            'stack.min' => trans('validation.min.string', ['attribute' => 'Количество товара в 1 стаке']),
            'price.min' => trans('validation.min.string', ['attribute' => 'Цена за стак товара'])
        ];
    }
}
