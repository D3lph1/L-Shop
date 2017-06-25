<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SaveOptimizationRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'ttl_statistic' => 'required|integer|min:1',
            'ttl_statistic_pages' => 'required|integer|min:1',
            'ttl_news' => 'required|integer|min:1',
            'ttl_monitoring' => 'required|numeric|min:0.1'
        ];
    }
}
