<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SaveAddedProductRequest extends FormRequest
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
            'stack' => 'required|numeric|integer|min:1',
            'price' => 'required|numeric|min:0,001',
            'server' => 'required|numeric',
            'category' => 'required|numeric'
        ];
    }

    public function messages()
    {


        return [
            'item.required' => trans('validation.required', ['attribute' => 'Привязать предмет']),
            'item.numeric' => trans('validation.numeric', ['attribute' => 'Привязать предмет']),
            'stack.required' => trans('validation.required', ['attribute' => 'Количество товара в 1 стаке']),
            'stack.numeric' => trans('validation.numeric', ['attribute' => 'Количество товара в 1 стаке']),
            'stack.integer' => trans('validation.integer', ['attribute' => 'Количество товара в 1 стаке']),
            'stack.min' => trans('validation.min.numeric', ['attribute' => 'Количество товара в 1 стаке']),
            'price.required' => trans('validation.required', ['attribute' => 'Цена за стак товара']),
            'price.numeric' => trans('validation.numeric', ['attribute' => 'Цена за стак товара']),
            'price.min' => trans('validation.min.numeric', ['attribute' => 'Цена за стак товара']),
            'server.required' => trans('validation.numeric', ['attribute' => 'Привязать к серверу/категории']),
            'category.required' => trans('validation.numeric', ['attribute' => 'Привязать к серверу/категории']),
        ];
    }
}
