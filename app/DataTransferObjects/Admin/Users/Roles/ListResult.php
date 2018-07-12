<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Users\Roles;

use App\Services\Response\JsonRespondent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListResult implements JsonRespondent
{
    /**
     * @var LengthAwarePaginator
     */
    private $paginator;

    /**
     * @var Role[]
     */
    private $roles = [];

    public function __construct(LengthAwarePaginator $paginator)
    {
        $this->paginator = $paginator;
        foreach ($this->paginator->items() as $item) {
            $this->roles[] = new Role($item);
        }
    }

    /**
     * @inheritDoc
     */
    public function response(): array
    {
        return [
            'paginator' => $this->paginator,
            'roles' => $this->roles
        ];
    }
}
