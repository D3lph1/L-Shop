<?php
declare(strict_types = 1);

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UploadCloakRequest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Requests\Profile
 */
class UploadCloakRequest extends FormRequest
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
        $max = s_get('profile.character.cloak.max_size', 512);

        return [
            'cloak' => 'file|image|mimetypes:image/png|max:' . $max
        ];
    }
}
