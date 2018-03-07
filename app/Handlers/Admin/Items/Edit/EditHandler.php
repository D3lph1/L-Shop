<?php
declare(strict_types=1);

namespace App\Handlers\Admin\Items\Edit;

use App\DataTransferObjects\Admin\Items\Edit\Edit;
use App\Entity\Enchantment;
use App\Entity\EnchantmentItem;
use App\Exceptions\InvalidArgumentTypeException;
use App\Exceptions\Item\DoesNotExistException;
use App\Exceptions\UnexpectedValueException;
use App\Repository\Enchantment\EnchantmentRepository;
use App\Repository\Item\ItemRepository;
use App\Services\Item\Image\Hashing\Hasher;
use App\Services\Item\Image\Image;
use App\Services\Item\Type;
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
    private $itemRepository;

    /**
     * @var EnchantmentRepository
     */
    private $enchantmentRepository;

    /**
     * @var Hasher
     */
    private $imageHasher;

    public function __construct(ItemRepository $itemRepository, EnchantmentRepository $enchantmentRepository, Hasher $imageHasher)
    {
        $this->itemRepository = $itemRepository;
        $this->enchantmentRepository = $enchantmentRepository;
        $this->imageHasher = $imageHasher;
    }

    public function handle(Edit $dto): void
    {
        $item = $this->itemRepository->find($dto->getId());
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

        if ($dto->getItemType() === Type::ITEM) {
            /** @var EnchantmentItem[] $ei */
            $ei = $item->getEnchantmentItems();
            $original = $dto->getEnchantments();
            $enchantments = $dto->getEnchantments();

            // Update edited enchantments.
            foreach ($enchantments as $key => &$each) {
                foreach ($ei as $eei) {
                    if ($eei->getEnchantment()->getId() === $each->getId()) {
                        $eei->setLevel($each->getLevel());
                        unset($enchantments[$key]);
                        continue;
                    }
                }
            }

            // Add new enchantments.
            $new = [];
            foreach ($enchantments as $each) {
                $new[] = $each->getId();
            }

            /** @var Enchantment[] $new */
            $new = $this->enchantmentRepository->findWhereIn($new);
            foreach ($new as $each) {
                foreach ($enchantments as $enchantment) {
                    if ($each->getId() === $enchantment->getId()) {
                        $enchantmentItem = new EnchantmentItem($each, $enchantment->getLevel());
                        $item->addEnchantmentItem($enchantmentItem);
                        $enchantmentItem->setItem($item);
                    }
                }
            }

            // Delete removed enchantments.
            /** @var EnchantmentItem $enchantment */
            foreach ($item->getEnchantmentItems() as $enchantment) {
                $f = false;
                foreach ($original as $each) {
                    if ($enchantment->getEnchantment()->getId() === $each->getId()) {
                        $f = true;
                        break;
                    }
                }

                if (!$f) {
                    $enchantment->deleteItem();
                    $item->removeEnchantmentItem($enchantment);
                }
            }
        }

        $this->itemRepository->update($item);
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
