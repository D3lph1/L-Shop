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
            'access_mode' => 'required',
            'enable_signup' => 'boolean',
            'enable_email_activation' => 'boolean',
            'products_per_page' => 'required|integer|min:1|max:1000',
            'cart_capacity' => 'required|integer|min:1',
            'maintenance' => 'boolean'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'shop_name.required' => trans('validation.required', ['attribute' => 'Имя магазина']),
            'shop_name.min' => trans('validation.min.string', ['attribute' => 'Имя магазина']),
            'shop_name.max' => trans('validation.max.string', ['attribute' => 'Имя магазина']),
            'access_mode.required' => trans('validation.required', ['attribute' => 'Режим доступа']),
            'products_per_page.required' => trans('validation.required', ['attribute' => 'Количество товара на 1 странице магазина']),
            'products_per_page.integer' => trans('validation.integer', ['attribute' => 'Количество товара на 1 странице магазина']),
            'products_per_page.min' => trans('validation.min', ['attribute' => 'Количество товара на 1 странице магазина']),
            'products_per_page.max' => trans('validation.max', ['attribute' => 'Количество товара на 1 странице магазина']),
            'cart_capacity.required' => trans('validation.required', ['attribute' => 'Максимальная вместимость корзины']),
            'cart_capacity.integer' => trans('validation.integer', ['attribute' => 'Максимальная вместимость корзины']),
            'cart_capacity.min' => trans('validation.min', ['attribute' => 'Максимальная вместимость корзины']),
        ];
    }
}
