<?php
declare(strict_types = 1);

namespace App\Exceptions\Role;

use App\Exceptions\DomainException;
use Throwable;

class DoesNotExistException extends DomainException
{
    /**
     * @var mixed
     */
    private $criteria;

    public function __construct($criteria, int $code = 0, Throwable $previous = null)
    {
        $this->criteria = $criteria;

        parent::__construct("Role `$criteria` does not exists", $code, $previous);
    }

    /**
     * @return mixed
     */
    public function getCriteria()
    {
        return $this->criteria;
    }
}
