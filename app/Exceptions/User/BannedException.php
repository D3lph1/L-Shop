<?php
declare(strict_types = 1);

namespace App\Exceptions\User;

use App\Exceptions\RuntimeException;
use Carbon\Carbon;
use Throwable;

/**
 * Class BannedException
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Exceptions\User
 */
class BannedException extends RuntimeException
{
    /**
     * @var null|Carbon
     */
    protected $until;

    /**
     * @var null|string
     */
    protected $reason;

    /**
     * BannedException constructor.
     */
    public function __construct(?Carbon $until, ?string $reason = null, int $code = 0, Throwable $previous = null)
    {
        $this->until = $until;
        $this->reason = $reason;

        parent::__construct(build_ban_message($until, $reason), $code, $previous);
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
