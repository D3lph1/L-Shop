<?php
declare(strict_types = 1);

namespace App\Exceptions\User;

use App\Exceptions\DomainException;

class DoesNotExistException extends DomainException
{
    /**
     * @var mixed
     */
    private $criteria;

    public function __construct($criteria, int $code = 0, \Throwable $previous = null)
    {
        $this->criteria = $criteria;

        parent::__construct("User `{$criteria}` does not exist", $code, $previous);
    }

    /**
     * @return mixed
     */
    public function getCriteria()
    {
        return $this->criteria;
    }
}
