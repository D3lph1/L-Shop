<?php
declare(strict_types = 1);

namespace App\Services\Response;

/**
 * Interface JsonRespondent
 * The interface is used to convert an object into a response format. It should be used with class
 * {@see JsonResponse}.
 * <p>For example:</p>
 * <code>
 *  class Example implements JsonRespondent
 *  {
 *      public function response(): array
 *      {
 *          return [
 *              'key1' => 'value1',
 *              // ...
 *          ]
 *      }
 *  }
 *
 *  $example = new Example();
 *  $response = new JsonResponse('some_status', $example);
 * </code>
 *
 * <p>Data received from the {@see JsonRespondent::response()}  will be merged with the other
 * response data.</p>
 */
interface JsonRespondent
{
    /**
     * Returns the data that should be added to the response.
     *
     * @return array
     */
    public function response(): array;
}
