<?php
declare(strict_types=1);

namespace App\Handlers\Admin\Items\Edit;

use App\DataTransferObjects\Admin\Items\Edit\Edit;
use App\Entity\Item;
use App\Exceptions\InvalidArgumentTypeException;
use App\Exceptions\Item\DoesNotExistException;
use App\Exceptions\UnexpectedValueException;
use App\Repository\Item\ItemRepository;
use App\Services\Item\Image\Hashing\Hasher;
use App\Services\Item\Image\Image;
use Illuminate\Http\UploadedFile;

class EditHandler
{
    private const IMAGE_CURRENT = 'current';

    private const IMAGE_DEFAULT = 'default';

    private const IMAGE_UPLOAD = 'upload';

    private const IMAGE_BROWSE = 'browse';

    /**
     * @var ItemRepository
     */
    private $repository;

    /**
     * @var Hasher
     */
    private $imageHasher;

    public function __construct(ItemRepository $repository, Hasher $imageHasher)
    {
        $this->repository = $repository;
        $this->imageHasher = $imageHasher;
    }

    public function handle(Edit $dto): void
    {
        $item = $this->repository->find($dto->getId());
        if ($item === null) {
            throw new DoesNotExistException($dto->getId());
        }

        $image = $this->imageName($dto->getImageType(), $dto->getFile() ?: $dto->getImageName(), $item->getImage());

        $item
            ->setName($dto->getName())
            ->setDescription($dto->getDescription())
            ->setType($dto->getItemType())
            ->setImage($image)
            ->setGameId($dto->getGameId())
            ->setExtra($dto->getExtra());

        $this->repository->update($item);
    }

    /**
     * @param string              $type
     * @param string|UploadedFile $fileOrName
     * @param string              $currentImage
     *
     * @return null|string Image name or null if image default.
     */
    private function imageName(string $type, $fileOrName, ?string $currentImage): ?string
    {
        if ($type === self::IMAGE_CURRENT) {
            return $currentImage;
        }

        if ($type === self::IMAGE_DEFAULT) {
            return null;
        }

        if ($type === self::IMAGE_BROWSE) {
            return $fileOrName;
        }

        if ($type === self::IMAGE_UPLOAD) {
            if ($fileOrName instanceof UploadedFile) {
                return $this->moveAndGetName($fileOrName);
            }

            throw new InvalidArgumentTypeException('$fileOrName', UploadedFile::class, $fileOrName);
        }

        throw new UnexpectedValueException('Unexpected value (' . $type . ') of argument $type');
    }

    private function moveAndGetName(UploadedFile $file): string
    {
        $hash = $this->imageHasher->make($file->path());
        $filename = "{$hash}.{$file->getClientOriginalExtension()}";
        $file->move(Image::absolutePath(), $filename);

        return $filename;
    }
}
