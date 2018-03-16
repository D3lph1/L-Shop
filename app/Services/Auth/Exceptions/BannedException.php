<?php
declare(strict_types = 1);

namespace App\Services\Auth\Exceptions;

use App\Entity\Ban;

class BannedException extends AuthException
{
    /**
     * @var Ban[]
     */
    private $bans;

    /**
     * BannedException constructor.
     *
     * @param Ban[] $bans
     */
    public function __construct(array $bans)
    {
        $this->bans = $bans;
        parent::__construct(
            "The user {$bans[0]->getUser()} is banned",
            0,
            null
        );
    }

    /**
     * @return Ban[]
     */
    public function getBans(): array
    {
        return $this->bans;
    }
}
