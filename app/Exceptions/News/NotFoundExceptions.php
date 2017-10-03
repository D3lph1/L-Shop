<?php
declare(strict_types = 1);

namespace App\Exceptions\News;

use App\Exceptions\DomainException;
use Throwable;

/**
 * Class NotFoundExceptions
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Exceptions\News
 */
class NotFoundExceptions extends DomainException
{
    public function __construct(int $newsId, $code = 0, Throwable $previous = null)
    {
        $message = "News with id `$newsId` not found";

        parent::__construct($message, $code, $previous);
    }
}
