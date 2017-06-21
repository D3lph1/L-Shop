<?php

namespace App\Exceptions\User;

use Carbon\Carbon;
use Throwable;

class BannedException extends \RuntimeException
{
    /**
     * @var null|Carbon
     */
    protected $until;

    /**
     * @var string
     */
    protected $reason;

    /**
     * BannedException constructor.
     *
     * @param null|Carbon         $until
     * @param null|string    $reason
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($until, $reason = null, $code = 0, Throwable $previous = null)
    {
        $this->until = $until;
        $this->reason = $reason;

        if (is_null($until)) {
            $until = "permanently";
        } else {
            $until = "until $until";
        }

        if ($reason) {
            $reason = "due to `$reason`";
        }

        $message = "User banned $until $reason";

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return null|Carbon
     */
    public function getUntil()
    {
        return $this->until;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }
}
