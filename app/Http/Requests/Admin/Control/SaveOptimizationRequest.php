<?php
declare(strict_types = 1);

namespace App\Http\Requests\Admin\Control;

use Illuminate\Foundation\Http\FormRequest;

class SaveOptimizationRequest extends FormRequest
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
            'monitoring_ttl' => 'required|integer|min:1'
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributes(): array
    {
        return [
            'monitoring_ttl' => __('content.admin.control.optimization.monitoring_ttl')
        ];
    }
}
