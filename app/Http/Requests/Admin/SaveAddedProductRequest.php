<?php
declare(strict_types = 1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SaveAddedProductRequest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Requests\Admin
 */
class SaveAddedProductRequest extends FormRequest
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
            'item' => 'required|numeric',
            'stack' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0.001',
            'sort_priority' => 'required|numeric',
            'server' => 'required|numeric',
            'category' => 'required|numeric'
        ];
    }

    public function messages(): array
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
