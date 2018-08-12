<?php
declare(strict_types = 1);

namespace App\Http\Requests\Admin\Pages;

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
            'title' => 'required|min:2|max:255',
            'content' => 'required|min:1',
            'url' => 'required|min:1|max:255'
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributes(): array
    {
        return [
            'title' => __('content.admin.pages.add.title_input'),
            'content' => __('content.admin.pages.add.content'),
            'url' => __('content.admin.pages.add.url')
        ];
    }
}
