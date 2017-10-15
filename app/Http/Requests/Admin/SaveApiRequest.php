<?php
declare(strict_types = 1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SaveApiRequest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Requests\Admin
 */
class SaveApiRequest extends FormRequest
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
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'api_enabled' => 'boolean',
            'key' => 'required|min:32|max:1024',
            'algo' => 'required',
            'separator' => 'required',
            'salt' => 'boolean',
            'signin_enabled' => 'boolean',
            'signin_remember' => 'boolean',
            'sashok_launcher_auth_format' => 'required|regex:/.*{username}.*/u',
            'sashok_launcher_auth_error_message' => 'required|min:1'
        ];
    }

    public function messages(): array
    {
        return [
            'key.required' => trans('validation.required', ['attribute' => 'Ключ доступа']),
            'key.min' => trans('validation.min', ['attribute' => 'Ключ доступа']),
            'key.max' => trans('validation.max', ['attribute' => 'Ключ доступа']),
            'key.algo' => trans('validation.required', ['attribute' => 'Алгоритм хэширования']),
        ];
    }
}
