<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Items\Add;

class EnchantmentFromFrontend
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $level;

    public function __construct(int $id, int $level)
    {
        $this->id = $id;
        $this->level = $level;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }
}
