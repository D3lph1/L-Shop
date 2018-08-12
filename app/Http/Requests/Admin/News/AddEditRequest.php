<?php
declare(strict_types = 1);

namespace App\Http\Requests\Admin\News;

use Illuminate\Foundation\Http\FormRequest;

class AddEditRequest extends FormRequest
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
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|min:2|max:128',
            'content' => 'required|min:2'
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributes(): array
    {
        return [
            'title' => __('content.admin.news.add.title_input'),
            'content' => __('content.admin.news.add.content')
        ];
    }
}
