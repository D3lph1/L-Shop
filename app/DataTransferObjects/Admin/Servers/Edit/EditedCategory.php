<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Servers\Edit;

class EditedCategory
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int|null
     */
    private $id;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     *
     * @return EditedCategory
     */
    public function setId(?int $id): EditedCategory
    {
        $this->id = $id;

        return $this;
    }
}
