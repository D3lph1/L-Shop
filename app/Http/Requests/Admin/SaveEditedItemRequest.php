<?php
declare(strict_types = 1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SaveEditedItemRequest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Requests\Admin
 */
class SaveEditedItemRequest extends FormRequest
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
            'name' => 'required|min:3|max:64',
            'item_type' => 'required',
            'image_mode' => 'required',
            'image' => 'required_if:image_mode,upload|image',
            'item' => 'required|min:1|max:64',
            'extra' => 'sometimes'
        ];
    }
}
