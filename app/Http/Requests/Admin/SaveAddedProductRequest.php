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
            'stack' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0.001',
            'sort_priority' => 'required|numeric',
            'server' => 'required|numeric',
            'category' => 'required|numeric'
        ];
    }

    public function messages()
    {
        $count = ['attribute' => 'Количество товара в 1 стаке'];
        $price = ['attribute' => 'Цена за стак товара'];

        return [
            'item.required' => trans('validation.required', ['attribute' => 'Привязать предмет']),
            'item.numeric' => trans('validation.numeric', ['attribute' => 'Привязать предмет']),
            'stack.required' => trans('validation.required', $count),
            'stack.numeric' => trans('validation.numeric', $count),
            'stack.integer' => trans('validation.integer', $count),
            'stack.min' => trans('validation.min.numeric', $count),
            'price.required' => trans('validation.required', $price),
            'price.numeric' => trans('validation.numeric', $price),
            'price.min' => trans('validation.min.numeric', $price),
            'server.required' => trans('validation.numeric', ['attribute' => 'Привязать к серверу/категории']),
            'category.required' => trans('validation.numeric', ['attribute' => 'Привязать к серверу/категории']),
        ];
    }
}
