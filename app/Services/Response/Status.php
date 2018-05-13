<?php
declare(strict_types = 1);

namespace App\Services\Response;

/**
 * Class Status
 * The class contains constants that should be used as the response status for the
 * {@see \App\Services\Infrastructure\Response\JsonResponse} class. It is
 * recommended that, together with the status of the text, use http
 * response statuses.
 */
class Status
{
    /**
     * The request was successful. All the operations that should have been performed
     * were completed successfully.
     */
    public const SUCCESS = 'success';

    /**
     * The request was made with an error.
     */
    public const FAILURE = 'failure';

    /**
     * Should be used in case the access to the resource is denied.
     */
    public const FORBIDDEN = 'forbidden';

    /**
     * Private constructor because this class contains only constants.
     */
    private function __construct()
    {
    }
}
