<?php
declare(strict_types = 1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class BlockUserRequest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Requests\Admin
 */
class BlockUserRequest extends FormRequest
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
            'block_duration' => 'required|integer|min:0'
        ];
    }
}
