<?php
declare(strict_types = 1);

namespace App\Http\Requests\Admin\Products;

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
            'item' => 'required|integer',
            'category' => 'required|integer',
            'price' => 'required|numeric|min:0.01',
            'stack' => 'nullable|required_if:forever,false|integer|min:0',
            'forever' => 'nullable|boolean',
            'sort_priority' => 'nullable|numeric',
            'hidden' => 'nullable|boolean'
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributes(): array
    {
        return [
            'item' => __('content.admin.products.add.item'),
            'category' => __('content.admin.products.add.category'),
            'forever' => __('content.admin.products.add.forever'),
            'sort_priority' => __('content.admin.products.add.sort_priority'),
            'hidden' => __('content.admin.products.add.hide'),
        ];
    }
}
