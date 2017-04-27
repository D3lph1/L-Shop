<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SaveEditedNewsRequest extends FormRequest
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
            'news_title' => 'required|min:2|max:191',
            'news_content' => 'required'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        $title = 'Заголовок новости';
        $content = 'Содержимое новости';

        return [
            'news_title.required' => trans('validation.required', ['attribute' => $title]),
            'news_title.min' => trans('validation.min.string', ['attribute' => $title]),
            'news_title.max' => trans('validation.max.string', ['attribute' => $title]),
            'news_content.required' => trans('validation.required', ['attribute' => $content]),
        ];
    }
}
