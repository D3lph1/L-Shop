<?php
declare(strict_types = 1);

namespace App\Http\Requests\Admin\Control;

use App\Services\Auth\AccessMode;
use App\Services\Validation\Rule;
use App\Services\Validation\RulesBuilder;
use Illuminate\Foundation\Http\FormRequest;

class SaveBasicSettingsRequest extends FormRequest
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
            'name' => 'required|min:2',
            'description' => 'required|min:2',
            'keywords' => 'required|array',
            'access_mode' => (new RulesBuilder())
                ->addRule(new Rule('required'))
                ->addRule(new Rule('in', [AccessMode::GUEST, AccessMode::AUTH, AccessMode::ANY]))
                ->build(),
            'register_enabled' => 'required|boolean',
            'send_activation_enabled' => 'required|boolean',
            'custom_redirect_enabled' => 'required|boolean',
            'custom_redirect_url' => 'nullable|string',

            'skin_enabled' => 'required|boolean',
            'skin_max_file_size' => 'required|integer|min:1',
            'skin_list' => 'required|array',
            'skin_list.*.*' => 'required|integer|min:1',
            'skin_hd_enabled' => 'required|boolean',
            'skin_hd_list' => 'required|array',
            'skin_hd_list.*.*' => 'required|integer|min:1',
            'cloak_enabled' => 'required|boolean',
            'cloak_max_file_size' => 'required|integer|min:1',
            'cloak_list' => 'required|array',
            'cloak_list.*.*' => 'required|integer|min:1',
            'cloak_hd_enabled' => 'required|boolean',
            'cloak_hd_list' => 'required|array',
            'cloak_hd_list.*.*' => 'required|integer|min:1',

            'catalog_per_page' => 'required|integer|min:1',
            'sort_products_by' => 'required|string',
            'sort_products_descending' => 'required|boolean',
            'news_enabled' => 'required|boolean',
            'news_per_portion' => 'required|integer|min:1',
            'monitoring_enabled' => 'required|boolean',
            'monitoring_rcon_timeout' => 'required|numeric|min:0.01',
            'monitoring_rcon_command' => 'required',
            'monitoring_rcon_response_pattern' => 'required|string|valid_regex',
            'maintenance_mode' => 'required|boolean'
        ];
    }
}
