<?php

namespace App\Traits;

/**
 * Trait Validator
 * Check data on valid
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Traits
 */
trait Validator
{
    /**
     * Config - path to validation array rules
     *
     * @var string
     */
    private $path = 'l-shop.validation';

    /**
     * @param string $username
     * @param bool   $required
     *
     * @return bool|\Illuminate\Http\JsonResponse
     *
     */
    public function validateUsername($username, $required = true)
    {
        $min = $this->getOption('username.min', 4);
        $max = $this->getOption('username.max', 32);
        $rule = $this->getOption('username.rule', 'alpha_dash');

        $required = $required ? 'required|' : 'sometimes|';

        $validator = \Validator::make([
                'username' => $username
            ],
            [
                'username' => "{$required}min:$min|max:$max|$rule"
            ]);

        if ($validator->fails()) {
            return json_response('invalid username');
        }

        return true;
    }

    public function validateFillUpBalanceSum($sum, $required = true)
    {

        $required = $required ? 'required|' : 'sometimes|';
        $min = s_get('payment.fillupbalance.minsum', 25);

        $validator = \Validator::make([
            'sum' => $sum
        ],
            [
                'sum' => "{$required}numeric|between:$min,2147000"
            ]);

        if ($validator->fails()) {
            return json_response('invalid sum', [
                'min' => $min
            ]);
        }

        return true;
    }

    /**
     * @param string     $option
     * @param null|mixed $default
     *
     * @return mixed
     */
    private function getOption($option, $default = null)
    {
        return config("{$this->path}.$option", $default);
    }
}
