<?php
declare(strict_types = 1);

namespace App\Http\Requests\Frontend\Profile\Character;

use App\Services\Settings\Settings;
use App\Services\Validation\Rule;
use App\Services\Validation\RulesBuilder;
use Illuminate\Foundation\Http\FormRequest;

class UploadCloakRequest extends FormRequest
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
     * @param Settings $settings
     *
     * @return array
     */
    public function rules(Settings $settings): array
    {
        $builder = (new RulesBuilder())
            ->addRule(new Rule('required'))
            ->addRule(new Rule('file'))
            ->addRule(new Rule('image'))
            ->addRule(new Rule('mimetypes', 'image/png'))
            ->addRule(new Rule('max', $settings->get('system.profile.character.cloak.max_file_size')->getValue()));

        return [
            'cloak' => $builder->build()
        ];
    }
}
