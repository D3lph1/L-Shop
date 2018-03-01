<?php
declare(strict_types = 1);

namespace App\Http\Requests\Admin\Items;

use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
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
            'name' => 'required|min:2|max:64',
            'description' => 'nullable',
            'item_type' => 'required',
            'image_type' => 'in:default,upload,browse',
            'file' => 'required_if:image_type,upload|file|image|mimes:jpeg,bmp,png,gif',
            'image_name' => 'required_if:image_type,browse|string|min:3',
            'game_id' => 'required',
            'extra' => 'nullable'
        ];
    }
}
