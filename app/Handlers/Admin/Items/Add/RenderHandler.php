<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Items\Add;

use App\DataTransferObjects\Admin\Items\Add\Enchantment;
use App\DataTransferObjects\Admin\Items\Add\Image;
use App\DataTransferObjects\Admin\Items\Add\Result;
use App\Repository\Enchantment\EnchantmentRepository;
use Illuminate\Filesystem\Filesystem;

class RenderHandler
{
    /**
     * @var EnchantmentRepository
     */
    private $enchantmentRepository;

    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct(EnchantmentRepository $enchantmentRepository, Filesystem $filesystem)
    {
        $this->enchantmentRepository = $enchantmentRepository;
        $this->filesystem = $filesystem;
    }

    public function handle(): Result
    {
        $images = [];
        foreach ($this->filesystem->allFiles(\App\Services\Item\Image\Image::absolutePath()) as $item) {
            $images[] = new Image($item);
        }

        $enchantments = [];
        foreach ($this->enchantmentRepository->findAll() as $each) {
            $enchantments[] = new Enchantment($each);
        }

        return new Result($images, $enchantments);
    }
}
