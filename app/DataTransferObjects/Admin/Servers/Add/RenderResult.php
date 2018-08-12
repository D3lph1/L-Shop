<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Servers\Add;

use App\Services\Response\JsonRespondent;

class RenderResult implements JsonRespondent
{
    /**
     * Names of distributor classes.
     *
     * @var string[]
     */
    private $distributors;

    public function __construct(array $distributors)
    {
        $this->distributors = $distributors;
    }

    /**
     * @inheritDoc
     */
    public function response(): array
    {
        return [
            'distributors' => $this->distributors
        ];
    }
}
