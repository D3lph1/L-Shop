<?php
declare(strict_types = 1);

namespace App\Http\Requests\Admin\Servers;

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
            'name' => 'required|min:1|max:64',
            'categories' => 'nullable|array',
            'categories.*' => 'required_with:categories|min:1|max:32',
            'ip' => 'nullable|ip',
            'port' => 'nullable|integer|min:1|max:65535',
            'password' => 'nullable',
            'monitoring_enabled' => 'required|boolean',
            'server_enabled' => 'required|boolean',
            'distributor' => 'required'
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributes(): array
    {
        return [
            'name' => __('content.admin.servers.add.name'),
            'categories' => __('content.admin.servers.add.categories'),
            'categories.*.name' => __('content.admin.servers.add.category_name'),
            'ip' => __('content.admin.servers.add.ip'),
            'port' => __('content.admin.servers.add.port'),
            'password' => __('content.admin.servers.add.password'),
            'monitoring_enabled' => __('content.admin.servers.add.monitoring_enabled'),
            'server_enabled' => __('content.admin.servers.add.server_enabled'),
            'distributor' => __('content.admin.servers.add.distributor')
        ];
    }
}
