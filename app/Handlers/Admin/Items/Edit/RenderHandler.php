<?php
declare(strict_types=1);

namespace App\Handlers\Admin\Items\Edit;

use App\DataTransferObjects\Admin\Items\Edit\Enchantment;
use App\DataTransferObjects\Admin\Items\Edit\Item;
use App\DataTransferObjects\Admin\Items\Edit\Result;
use App\Entity\EnchantmentItem;
use App\Exceptions\Item\DoesNotExistException;
use App\Repository\Enchantment\EnchantmentRepository;
use App\Repository\Item\ItemRepository;
use App\Services\Item\Image\Image;

class RenderHandler
{
    /**
     * @var ItemRepository
     */
    private $itemRepository;

    /**
     * @var EnchantmentRepository
     */
    private $enchantmentRepository;

    public function __construct(ItemRepository $itemRepository, EnchantmentRepository $enchantmentRepository)
    {
        $this->itemRepository = $itemRepository;
        $this->enchantmentRepository = $enchantmentRepository;
    }

    public function handle(int $itemId): Result
    {
        $item = $this->itemRepository->find($itemId);
        if ($item === null) {
            throw new DoesNotExistException($itemId);
        }
        $images = [];
        foreach (\File::allFiles(Image::absolutePath()) as $image) {
            $images[] = new \App\DataTransferObjects\Admin\Items\Add\Image($image);
        }

        $enchantments = [];
        foreach ($this->enchantmentRepository->findAll() as $enchantment) {
            $ei = null;
            /** @var EnchantmentItem $enchantmentItem */
            foreach ($item->getEnchantmentItems() as $enchantmentItem) {
                if ($enchantmentItem->getEnchantment()->getId() === $enchantment->getId()) {
                    $ei = $enchantmentItem;
                    break;
                }
            }
            $enchantments[] = new Enchantment($enchantment, $ei);
        }

        return new Result(new Item($item), $images, $enchantments);
    }
}
