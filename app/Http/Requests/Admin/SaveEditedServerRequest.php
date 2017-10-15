<?php
declare(strict_types = 1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SaveEditedServerRequest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Requests\Admin
 */
class SaveEditedServerRequest extends FormRequest
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
            'server_name' => 'required|min:2|max:32',
            'categories' => 'required|array',
            'categories.*.*' => 'required|min:2|max:32',
            'enabled' => 'boolean',
            'server_ip' => 'ip',
            'server_port' => 'integer',
            'server_password' => 'max:64',
            'server_monitoring_enabled' => 'boolean'
        ];
    }
}
