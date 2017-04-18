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
        ];
    }

    public function messages()
    {
        $ttlStatistic = 'Время существования кэша статистики';
        $ttlStaticPages = 'Время существования кэша статических страниц';

        return [
            'ttl_statistic.required' => trans('validation.required', ['attribute' => $ttlStatistic]),
            'ttl_statistic.integer' => trans('validation.integer', ['attribute' => $ttlStatistic]),
            'ttl_statistic.min' => trans('validation.min.numeric', ['attribute' => $ttlStatistic]),
            'ttl_statistic_pages.required' => trans('validation.min.numeric', ['attribute' => $ttlStaticPages]),
            'ttl_statistic_pages.integer' => trans('validation.min.numeric', ['attribute' => $ttlStaticPages]),
            'ttl_statistic_pages.min' => trans('validation.min.numeric', ['attribute' => $ttlStaticPages]),
        ];
    }
}
