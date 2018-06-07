<?php
declare(strict_types = 1);

namespace App\DataTransferObjects;

class PaginationList
{
    /**
     * @var string|null
     */
    private $orderBy;

    /**
     * @var bool
     */
    private $descending;

    /**
     * @var string|null
     */
    private $search;

    /**
     * @var int
     */
    private $page = 1;

    /**
     * @var int
     */
    private $perPage;

    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }

    public function setOrderBy(?string $by): PaginationList
    {
        $this->orderBy = $by;

        return $this;
    }

    public function isDescending(): bool
    {
        return $this->descending;
    }

    public function setDescending(bool $descending): PaginationList
    {
        $this->descending = $descending;

        return $this;
    }

    public function getSearch(): ?string
    {
        return $this->search;
    }

    public function setSearch(?string $search): PaginationList
    {
        $this->search = $search;

        return $this;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): PaginationList
    {
        $this->page = $page;

        return $this;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function setPerPage(int $perPage): PaginationList
    {
        $this->perPage = $perPage;

        return $this;
    }
}
