<?php
declare(strict_types = 1);

namespace App\DataTransferObjects;

use App\Exceptions\UnexpectedValueException;
use App\Services\Items\ImageMode;
use App\Services\Items\Type;
use Illuminate\Http\UploadedFile;

/**
 * Class Item
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\DataTransferObjects\Admin
 */
class Item
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $type;

    /**
     * @var UploadedFile
     */
    private $image;

    /**
     * @var string
     */
    private $imageName;

    /**
     * @var string
     */
    private $imageMode;

    /**
     * @var string
     */
    private $item;

    /**
     * @var string
     */
    private $extra;

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setType(string $type): self
    {
        if (!in_array($type, (new \ReflectionClass(Type::class))->getConstants())) {
            throw new UnexpectedValueException(
                'The type must contain the value of one of the constants of class App\Services\Items\Type, '
                . $type . ' given'
            );
        }

        $this->type = $type;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setImageMode(string $mode): self
    {
        if (!in_array($mode, (new \ReflectionClass(ImageMode::class))->getConstants())) {
            throw new UnexpectedValueException(
                'The type must contain the value of one of the constants of class App\Services\Items\ImageMode, '
                . $mode . ' given'
            );
        }

        $this->imageMode = $mode;

        return $this;
    }

    public function getImageMode(): ?string
    {
        return $this->imageMode;
    }

    public function setImage(?UploadedFile $file): self
    {
        $this->image = $file;

        return $this;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getImage(): ?UploadedFile
    {
        return $this->image;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setItem(string $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getItem(): string
    {
        return $this->item;
    }

    public function setExtra(?string $extra): self
    {
        $this->extra = $extra;

        return $this;
    }

    public function getExtra(): ?string
    {
        return $this->extra;
    }
}
