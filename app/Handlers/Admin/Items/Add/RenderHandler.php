<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Items\Add;

use App\DataTransferObjects\Admin\Items\Add\Enchantment;
use App\DataTransferObjects\Admin\Items\Add\Image;
use App\DataTransferObjects\Admin\Items\Add\Result;
use App\Repository\Enchantment\EnchantmentRepository;

class RenderHandler
{
    /**
     * @var EnchantmentRepository
     */
    private $enchantmentRepository;

    public function __construct(EnchantmentRepository $enchantmentRepository)
    {
        $this->enchantmentRepository = $enchantmentRepository;
    }

    public function handle(): Result
    {
        $images = [];
        foreach (\File::allFiles(\App\Services\Item\Image\Image::absolutePath()) as $item) {
            $images[] = new Image($item);
        }

        $enchantments = [];
        foreach ($this->enchantmentRepository->findAll() as $each) {
            $enchantments[] = new Enchantment($each);
        }

        return new Result($images, $enchantments);
    }
}
