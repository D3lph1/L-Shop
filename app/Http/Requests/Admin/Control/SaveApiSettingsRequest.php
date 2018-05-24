<?php
declare(strict_types = 1);

namespace App\Http\Requests\Admin\Control;

use App\Services\Validation\Rule;
use App\Services\Validation\RulesBuilder;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Http\FormRequest;

class SaveApiSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param Repository $config
     *
     * @return array
     */
    public function rules(Repository $config): array
    {
        return [
            'enabled' => 'required|boolean',
            'key' => 'required|min:16',
            'delimiter' => 'nullable',
            'algorithm' => (new RulesBuilder())
                ->addRule(new Rule('required'))
                ->addRule(new Rule('in', $config->get('system.api.algorithms')))
                ->build(),
            'auth_enabled' => 'required|boolean',
            'register_enabled' => 'required|boolean',
            'sashok724sV3_launcher_enabled' => 'required|boolean',
            'sashok724sV3_launcher_format' => 'nullable|required_if:sashok724sV3_launcher_enabled,true|min:1',
            'sashok724sV3_launcher_IPs' => 'nullable|array',
            'sashok724sV3_launcher_IPs.*' => 'ip'
        ];
    }
}
