<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SaveEditedItemRequest extends FormRequest
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
            'name' => 'required|min:3|max:64',
            'image_mode' => 'required',
            'image' => 'required_if:image_mode,upload|image',
            'item' => 'required|min:1|max:64',
            'extra' => 'sometimes'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('validation.required', ['attribute' => 'Название предмета']),
            'name.min' => trans('validation.min.string', ['attribute' => 'Название предмета']),
            'name.max' => trans('validation.max.string', ['attribute' => 'Название предмета']),
            'image.image' => trans('validation.image', ['attribute' => 'Изображение']),
            'image.required_if' => trans('validation.required_if', [
                'attribute' => 'Изображение',
                'other' => 'Изображения',
                'value' => 'Загрузить изображение'
            ]),
            'item.required' => trans('validation.required', ['attribute' => 'ID или ID:DATA предмета']),
            'item.min' => trans('validation.min.string', ['attribute' => 'ID или ID:DATA предмета']),
            'item.max' => trans('validation.max.string', ['attribute' => 'ID или ID:DATA предмета'])
        ];
    }
}
