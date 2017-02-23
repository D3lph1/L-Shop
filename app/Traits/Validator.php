<?php

namespace App\Traits;

/**
 * Class Validator
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
     * @param mixed $username
     * @param bool  $required
     *
     * @return bool|\Illuminate\Http\JsonResponse
     *
     */
    public function checkUsername($username, $required = true)
    {
        $min = $this->get('username.min', 4);
        $max = $this->get('username.max', 32);
        $rule = $this->get('username.rule', 'alpha_dash');

        $required = $required ? 'required|' : '';

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

    /**
     * @param string     $option
     * @param null|mixed $default
     *
     * @return mixed
     */
    private function get($option, $default = null)
    {
        return config("{$this->path}.$option", $default);
    }
}
