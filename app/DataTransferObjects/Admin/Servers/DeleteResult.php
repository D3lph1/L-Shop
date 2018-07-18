<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Servers;

use App\Services\Response\JsonRespondent;

class DeleteResult implements JsonRespondent
{
    /**
     * @var bool
     */
    private $destroyPersistence;

    public function __construct(bool $destroyPersistence)
    {
        $this->destroyPersistence = $destroyPersistence;
    }

    /**
     * @inheritDoc
     */
    public function response(): array
    {
        return [
            'destroyPersistence' => $this->destroyPersistence
        ];
    }
}
