<?php
declare(strict_types = 1);

namespace App\TransactionScripts;

use App\DataTransferObjects\Item;
use App\Exceptions\Item\NotFoundException;
use App\Models\Item\ItemInterface;
use App\Repositories\Item\ItemRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\Items\ImageMode;
use DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;

class Items
{
    /**
     * @var ItemRepositoryInterface
     */
    private $itemRepository;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(ItemRepositoryInterface $itemRepository, ProductRepositoryInterface $productRepository)
    {
        $this->itemRepository = $itemRepository;
        $this->productRepository = $productRepository;
    }

    public function informationForList(?string $orderBy, ?string $orderType, ?string $filter): LengthAwarePaginator
    {
        if (is_null($orderBy)) {
            $orderBy = 'items.id';
        }

        if (is_null($orderType)) {
            $orderType = 'ASC';
        }

        return $this->itemRepository->forAdmin(
            ['id', 'name', 'type', 'image', 'extra'],
            $orderBy,
            $orderType,
            $filter
        );
    }

    public function find(int $itemId): ItemInterface
    {
        $item = $this->itemRepository->find($itemId, ['id', 'name', 'type', 'item', 'image', 'extra']);

        if (is_null($item)) {
            throw new NotFoundException($itemId);
        }

        return $item;
    }

    public function create(Item $dto): bool
    {
        if ($dto->getImageMode() === ImageMode::UPLOAD) {
            $dto->setImageName($this->moveImageAndGetName($dto->getImage()));
        } else if ($dto->getImageMode() === ImageMode::DEFAULT) {
            $dto->setImageName(null);
        }

        return (bool)$this->itemRepository->create($dto);
    }

    public function update(int $itemId, Item $dto): bool
    {
        $attributes = [
            'name' => $dto->getName(),
            'description' => $dto->getDescription(),
            'type' => $dto->getType(),
            'image' => $dto->getImage(),
            'item' => $dto->getItem(),
            'extra' => $dto->getExtra()
        ];

        if ($dto->getImageMode() === ImageMode::UPLOAD) {
            $attributes['image'] = $this->moveImageAndGetName($dto->getImage());
        } else if ($dto->getImageMode() === ImageMode::DEFAULT) {
            $attributes['image'] = null;
        } else if ($dto->getImageMode() === ImageMode::CURRENT) {
            unset($attributes['image']);
        }

        return DB::transaction(function () use ($itemId, $attributes) {
            return $this->itemRepository->update($itemId, $attributes);
        });
    }

    public function delete(int $itemId): bool
    {
        return (bool)DB::transaction(function () use ($itemId) {
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
