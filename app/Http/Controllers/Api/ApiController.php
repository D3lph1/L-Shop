<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

/**
 * Class ApiController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Api
 */
class ApiController extends Controller
{
    protected function isEnabled($option = null)
    {
        if (is_null($option)) {
            return (bool)s_get('api.enabled');
        }

        return (bool)s_get('api.enabled') && (bool)s_get('api.' . $option . '.enabled');
    }

    /**
     * It checks whether the hash transmitted in the request matches the calculated hash of the query parameters
     *
     * @param string $hash
     * @param array  ...$params
     *
     * @return bool
     */
    protected function validateHash($hash, ...$params)
    {
        $key = s_get('api.key');
        $algo = s_get('api.algo');
        $separator = s_get('api.separator');

        $string = $this->buildStringForHashing($key, $separator, $params);
        $calculated = hash($algo, $string);

        return $hash === $calculated;
    }

    /**
     * Build string for hashing from params
     *
     * @param string $key Secret API key
     * @param string $separator String (character) separating parameters
     * @param array  $params Params
     *
     * @return string
     */
    private function buildStringForHashing($key, $separator, array $params)
    {
        $string = $key;
        foreach ($params as $param) {
            $string .= $separator . $param;
        }

        return $string;
    }

    /**
     * Build response if option disabled
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function optionDisabledResponse()
    {
        return json_response('option disabled', ['code' => -1]);
    }

    /**
     * Build response if hash is not valid
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidHashResponse()
    {
        return json_response('invalid hash', ['code' => -2]);
    }
}
