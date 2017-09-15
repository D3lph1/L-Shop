<?php
declare(strict_types = 1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SaveOptimizationRequest
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Requests\Admin
 */
class SaveOptimizationRequest extends FormRequest
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
            'ttl_statistic' => 'required|integer|min:1',
            'ttl_statistic_pages' => 'required|integer|min:1',
            'ttl_news' => 'required|integer|min:1',
            'ttl_monitoring' => 'required|numeric|min:0.1'
        ];
    }
}
