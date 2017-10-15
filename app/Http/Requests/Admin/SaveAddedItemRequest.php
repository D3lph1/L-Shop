<?php
declare(strict_types = 1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SaveAddedItemRequest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Requests\Admin
 */
class SaveAddedItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
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
            'name' => 'required|min:3|max:64',
            'image_mode' => 'required',
            'image' => 'required_if:image_mode,upload|image',
            'item' => 'required|min:1|max:64',
            'extra' => 'sometimes'
        ];
    }

    public function messages(): array
    {
        $itemType = $this->get('item_type');

        return [
            'name.required' => trans('validation.required', ['attribute' => 'Название предмета']),
            'name.min' => trans('validation.min.string', ['attribute' => 'Название предмета']),
            'name.max' => trans('validation.max.string', ['attribute' => 'Название предмета']),
            'image.image' => trans('validation.image', ['attribute' => 'Изображение']),
            'image.required_if' => trans('validation.required_if', [
                'attribute' => 'Изображение',
                'other' => 'Тип изображения',
                'value' => 'Загрузить изображение'
            ]),
            'item.required' => trans('validation.required', ['attribute' => $itemType == 'item' ? 'ID или ID:DATA предмета' : 'Внутриигровой идентификатор привилегии']),
            'item.min' => trans('validation.min.string', ['attribute' => $itemType == 'item' ? 'ID или ID:DATA предмета' : 'Внутриигровой идентификатор привилегии']),
            'item.max' => trans('validation.max.string', ['attribute' => $itemType == 'item' ? 'ID или ID:DATA предмета' : 'Внутриигровой идентификатор привилегии'])
        ];
    }
}
