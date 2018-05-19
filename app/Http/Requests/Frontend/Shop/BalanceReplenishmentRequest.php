<?php
declare(strict_types = 1);

namespace App\Http\Requests\Frontend\Shop;

use App\Services\Settings\DataType;
use App\Services\Settings\Settings;
use App\Services\Validation\Rule;
use App\Services\Validation\RulesBuilder;
use Illuminate\Foundation\Http\FormRequest;

class BalanceReplenishmentRequest extends FormRequest
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
        return [
            'sum' => (new RulesBuilder())
                ->addRule(new Rule('required'))
                ->addRule(new Rule('numeric'))
                ->addRule(
                    new Rule(
                        'min',
                        $settings
                            ->get('purchasing.min_fill_balance_sum')
                            ->getValue(DataType::FLOAT))
                )
                ->build()
        ];
    }
}
