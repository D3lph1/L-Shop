<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SaveEditedPageRequest extends FormRequest
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
            'page_title' => 'required|min:2|max:191',
            'page_content' => 'required',
            'page_url' => 'required|min:2|max:191|regex:/^[a-z_\-`0-9]+$/ui'
        ];
    }

    public function messages()
    {
        return [
            'page_title.required' => trans('validation.required', ['attribute' => 'Заголовок страницы']),
            'page_title.min' => trans('validation.min.string', ['attribute' => 'Заголовок страницы']),
            'page_title.max' => trans('validation.max.string', ['attribute' => 'Заголовок страницы']),
            'page_content.required' => trans('validation.required', ['attribute' => 'Содержимое страницы']),
            'page_url.required' => trans('validation.required', ['attribute' => 'Адрес страницы']),
            'page_url.min' => trans('validation.min.string', ['attribute' => 'Адрес страницы', 'min' => 2]),
            'page_url.max' => trans('validation.max.string', ['attribute' => 'Адрес страницы', 'max' => 191]),
            'page_url.regex' => trans('validation.regex', ['attribute' => 'Адрес страницы'])
        ];
    }
}
