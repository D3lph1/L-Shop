<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * Class ApiController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Api
 */
abstract class ApiController extends Controller
{
    /**
     * Check given api parameter for enabled status.
     */
    protected function isEnabled(?string $option = null): bool
    {
        if (is_null($option)) {
            return (bool)s_get('api.enabled');
        }

        return (bool)s_get('api.enabled') && (bool)s_get('api.' . $option . '.enabled');
    }

    /**
     * It checks whether the hash transmitted in the request matches the calculated hash of the query parameters.
     */
    protected function validateHash(string $hash, ...$params): bool
    {
        $key = s_get('api.key');
        $algo = s_get('api.algo');
        $separator = s_get('api.separator');

        $string = $this->buildStringForHashing($key, $separator, $params);
        $calculated = hash($algo, $string);

        return $hash === $calculated;
    }

    /**
     * Build string for hashing from params.
     *
     * @param string $key Secret API key.
     * @param string $separator String (character) separating parameters.
     * @param array  $params Params.
     *
     * @return string
     */
    private function buildStringForHashing(string $key, string $separator, array $params): string
    {
        $string = $key;
        foreach ($params as $param) {
            $string .= $separator . $param;
        }

        return $string;
    }

    /**
     * Build response if option disabled.
     */
    protected function optionDisabledResponse(): JsonResponse
    {
        return json_response('option disabled', ['code' => -1]);
    }

    /**
     * Build response if hash is not valid.
     */
    protected function invalidHashResponse(): JsonResponse
    {
        return json_response('invalid hash', ['code' => -2]);
    }
}
