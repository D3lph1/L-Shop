<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Items\Edit;

use App\DataTransferObjects\Admin\Items\Edit\Item;
use App\DataTransferObjects\Admin\Items\Edit\Result;
use App\Exceptions\Item\DoesNotExistException;
use App\Repository\Item\ItemRepository;
use App\Services\Item\Image\Image;

class RenderHandler
{
    /**
     * @var ItemRepository
     */
    private $repository;

    public function __construct(ItemRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(int $itemId): Result
    {
        $item = $this->repository->find($itemId);
        if ($item === null) {
            throw new DoesNotExistException($itemId);
        }
        $images = [];
        foreach (\File::allFiles(Image::absolutePath()) as $image) {
            $images[] = new \App\DataTransferObjects\Admin\Items\Add\Image($image);
        }

        return new Result(new Item($item), $images);
    }
}
