<?php
declare(strict_types = 1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SaveMainSettingsRequest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Requests\Admin
 */
class SaveMainSettingsRequest extends FormRequest
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
            'shop_name' => 'required|min:2|max:128',
            'shop_description' => 'sometimes',
            'shop_keywords' => 'sometimes',
            'access_mode' => 'required',
            'enable_signup' => 'boolean',
            'enable_email_activation' => 'boolean',
            'signup_redirect' => 'boolean',
            'signup_redirect_url' => 'required_if:signup_redirect,1|url',

            'character_skin_enabled' => 'boolean',
            'character_cloak_enabled' => 'boolean',
            'character_hd_skin_enabled' => 'boolean',
            'character_hd_cloak_enabled' => 'boolean',
            'character_skin_max_file_size' => 'required|integer|min:1',
            'character_cloak_max_file_size' => 'required|integer|min:1',

            'news_first_portion' => 'required|integer|min:1|max:1000',
            'news_per_page' => 'required|integer|min:1|max:1000',
            'products_per_page' => 'required|integer|min:1|max:1000',
            'payments_per_page' => 'required|integer|min:1|max:1000',
            'cart_per_page' => 'required|integer|min:1|max:1000',
            'monitoring.enabled' => 'bool',
            'cart_capacity' => 'required|integer|min:1',
            'rcon_connection_timeout' => 'required|numeric|min:0.01',
            'maintenance' => 'boolean',
        ];
    }
}
