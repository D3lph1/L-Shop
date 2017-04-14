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
            'ttl_statistic' => 'required|integer|min:1'
        ];
    }

    public function messages()
    {
        $ttlStatistic = 'Время существования кэша статистики';

        return [
            'ttl_statistic.required' => trans('validation.required', ['attribute' => $ttlStatistic]),
            'ttl_statistic.integer' => trans('validation.integer', ['attribute' => $ttlStatistic]),
            'ttl_statistic.min' => trans('validation.min.numeric', ['attribute' => $ttlStatistic]),
        ];
    }
}
