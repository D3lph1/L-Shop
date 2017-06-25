<?php

namespace App\Services;

use App\Repositories\ItemRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\UploadedFile;

/**
 * Class AdminItems
 * Service that works with items in the admin panel.
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services
 */
class AdminItems
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

    /**
     * Create new item.
     *
     * @param string            $name        New item name.
     * @param string            $description New item description.
     * @param string            $type        New item type (item/permgroup).
     * @param null|UploadedFile $imageFile   New item image.
     * @param int               $item        New item in-game identifier.
     * @param string            $extra       New item extra data.
     *
     * @return mixed
     */
    public function create($name, $description, $type, $imageFile, $item, $extra)
    {
        $type = $this->getType($type);
        $image = $this->getFilename($imageFile);

        return \DB::transaction(function () use ($name, $description, $type, $image, $item, $extra) {
            return $this->itemRepository->create([
                'name' => $name,
                'description' => $description,
                'type' => $type,
                'image' => $image,
                'item' => $item,
                'extra' => $extra
            ]);
        });
    }

    /**
     * Update given item.
     *
     * @param int          $itemId      Updated item identifier.
     * @param string       $name        Item name.
     * @param string       $description Item description.
     * @param string       $type        Item type (item/permgroup).
     * @param string       $imageMode   Image mode (New uploaded or old image).
     * @param UploadedFile $imageFile   Item image.
     * @param int          $item        Item in-game identifier.
     * @param string       $extra       Item extra data.
     *
     * @return mixed
     */
    public function saveEdited($itemId, $name, $description, $type, $imageMode, $imageFile, $item, $extra)
    {
        $type = $this->getType($type);
        $image = $this->getFilename($imageFile);

        return \DB::transaction(function () use ($itemId, $name, $description, $type, $imageMode, $image, $item, $extra) {
            $attributes = [
                'name' => $name,
                'description' => $description,
                'type' => $type,
                'image' => $image,
                'item' => $item,
                'extra' => $extra
            ];

            if ($imageMode === 'current') {
                unset($attributes['image']);
            }

            return $this->itemRepository->update($itemId, $attributes);
        });
    }

    /**
     * Delete items with related products.
     *
     * @param int $itemId Item identifier.
     *
     * @return mixed
     */
    public function delete($itemId)
    {
        return (bool)\DB::transaction(function () use ($itemId) {
            $result = $this->itemRepository->delete($itemId);
            $this->productRepository->deleteByItemId($itemId);

            return $result;
        });
    }

    /**
     * Return a valid type string.
     *
     * @param string $type
     *
     * @return string
     */
    private function getType($type)
    {
        return $type === 'item' ? 'item' : 'permgroup';
    }

    /**
     * Get filename by UploadedFile instance.
     *
     * @param null|UploadedFile $file
     *
     * @return null|string
     */
    private function getFilename($file)
    {
        if ($file) {
            return $this->moveImageAndGetName($file);
        }

        return null;
    }

    /**
     * Calculate the name of a file using md5, move it and return filename.
     *
     * @param UploadedFile $file
     *
     * @return string
     */
    private function moveImageAndGetName(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $md5 = md5_file(sys_get_temp_dir() . DIRECTORY_SEPARATOR . $file->getFilename());
        $filename = $md5 . '.' . $extension;
        $file->move(public_path('img/items'), $filename);

        return $filename;
    }
}
