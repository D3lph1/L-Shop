<?php
declare(strict_types=1);

namespace App\Services\Handlers\Items;

use App\DataTransferObjects\Admin\Item;
use App\Exceptions\UnexpectedValueException;
use App\Repositories\ItemRepository;
use App\Repositories\ProductRepository;
use App\Services\Items\ImageMode;
use Illuminate\Http\UploadedFile;

/**
 * Class AdminItems
 * Service that works with items in the admin panel.
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services
 */
class Admin
{
    /**
     * @var ItemRepository
     */
    private $itemRepository;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @param ItemRepository    $itemRepository
     * @param ProductRepository $productRepository
     */
    public function __construct(ItemRepository $itemRepository, ProductRepository $productRepository)
    {
        $this->itemRepository = $itemRepository;
        $this->productRepository = $productRepository;
    }

    public function find(int $id)
    {
        $item = $this->itemRepository->find($id, [
            'id',
            'name',
            'type',
            'item',
            'image',
            'extra'
        ]);

        if (!$item) {
            app()->abort(404);
        }

        return $item;
    }

    public function create(Item $dto): ?\App\Models\Item
    {
        if ($dto->getImageMode() === ImageMode::UPLOAD) {
            $image = $this->moveImageAndGetName($dto->getImage());
        } else if ($dto->getImageMode() === ImageMode::DEFAULT) {
            $image = null;
        } else {
            throw new UnexpectedValueException(
                "Value \"{$dto->getImageMode()}\" of image mode not supported in this operation"
            );
        }

        return \DB::transaction(function () use ($dto, $image) {
            return $this->itemRepository->create([
                'name' => $dto->getName(),
                'description' => $dto->getDescription(),
                'type' => $dto->getType(),
                'image' => $image,
                'item' => $dto->getItemId(),
                'extra' => $dto->getExtra()
            ]);
        });
    }

    /**
     * Update given item.
     */
    public function update(Item $dto): bool
    {
        $attributes = [
            'name' => $dto->getName(),
            'description' => $dto->getDescription(),
            'type' => $dto->getType(),
            'image' => $dto->getImage(),
            'item' => $dto->getItemId(),
            'extra' => $dto->getExtra()
        ];

        if ($dto->getImageMode() === ImageMode::UPLOAD) {
            $attributes['image'] = $this->moveImageAndGetName($dto->getImage());
        } else if ($dto->getImageMode() === ImageMode::DEFAULT) {
            $attributes['image'] = null;
        } else if ($dto->getImageMode() === ImageMode::CURRENT) {
            unset($attributes['image']);
        }

        return (bool)\DB::transaction(function () use ($dto, $attributes) {
            return $this->itemRepository->update($dto->getId(), $attributes);
        });
    }

    /**
     * Delete items with related products.
     */
    public function delete(int $itemId): bool
    {
        return (bool)\DB::transaction(function () use ($itemId) {
            $result = $this->itemRepository->delete($itemId);
            $this->productRepository->deleteByItemId($itemId);

            return $result;
        });
    }

    /**
     * Calculate the name of a file using md5, move it and return filename.
     */
    private function moveImageAndGetName(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $md5 = md5_file(sys_get_temp_dir() . DIRECTORY_SEPARATOR . $file->getFilename());
        $filename = $md5 . '.' . $extension;
        $file->move(public_path('img/items'), $filename);

        return $filename;
    }
}
