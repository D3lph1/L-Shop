<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Users\Edit;

use App\DataTransferObjects\PaginationList as BasePaginationList;

class PaginationList extends BasePaginationList
{
    /**
     * @var int
     */
    private $userId;

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     *
     * @return PaginationList
     */
    public function setUserId(int $userId): PaginationList
    {
        $this->userId = $userId;

        return $this;
    }
}
