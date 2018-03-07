<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Items\Edit;

use App\DataTransferObjects\Admin\Items\Add\EnchantmentFromFrontend;
use Illuminate\Http\UploadedFile;

class Edit
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
     * @var null|string
     */
    private $description;

    /**
     * @var string
     */
    private $itemType;

    /**
     * @var string
     */
    private $imageType;

    /**
     * @var null|UploadedFile
     */
    private $file;

    /**
     * @var null|string
     */
    private $imageName;

    /**
     * @var string
     */
    private $gameId;

    /**
     * @var EnchantmentFromFrontend[]
     */
    private $enchantments;

    /**
     * @var null|string
     */
    private $extra;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Edit
     */
    public function setId(int $id): Edit
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return Edit
     */
    public function setName(string $name): Edit
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param null|string $description
     *
     * @return Edit
     */
    public function setDescription(?string $description): Edit
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $itemType
     *
     * @return Edit
     */
    public function setItemType(string $itemType): Edit
    {
        $this->itemType = $itemType;

        return $this;
    }

    /**
     * @return string
     */
    public function getItemType(): string
    {
        return $this->itemType;
    }

    /**
     * @param string $imageType
     *
     * @return Edit
     */
    public function setImageType(string $imageType): Edit
    {
        $this->imageType = $imageType;

        return $this;
    }

    /**
     * @return string
     */
    public function getImageType(): string
    {
        return $this->imageType;
    }

    /**
     * @param UploadedFile|null $file
     *
     * @return Edit
     */
    public function setFile(?UploadedFile $file): Edit
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return UploadedFile|null
     */
    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    /**
     * @param null|string $imageName
     *
     * @return Edit
     */
    public function setImageName(?string $imageName): Edit
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @param string $gameId
     *
     * @return Edit
     */
    public function setGameId(string $gameId): Edit
    {
        $this->gameId = $gameId;

        return $this;
    }

    /**
     * @return string
     */
    public function getGameId(): string
    {
        return $this->gameId;
    }

    /**
     * @param EnchantmentFromFrontend[] $enchantments
     *
     * @return Edit
     */
    public function setEnchantments(array $enchantments): Edit
    {
        $this->enchantments = $enchantments;

        return $this;
    }

    /**
     * @return EnchantmentFromFrontend[]
     */
    public function getEnchantments(): array
    {
        return $this->enchantments;
    }

    /**
     * @param null|string $extra
     *
     * @return Edit
     */
    public function setExtra(?string $extra): Edit
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getExtra(): ?string
    {
        return $this->extra;
    }
}
